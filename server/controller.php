<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

use Soap\Url;

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

/*
function readMoviesController(){
    $movies = getAllMovies($min_age);
    return $movies;
}*/
function readCategoryController(){
    $category = getAllCategories();
    return $category;
}
function readMoviesByCategoryController(){
$min_age = $_REQUEST['min_age'];
    $movies = getAllMovies($min_age);
    if (empty($movies)) {
        return ["error" => "Aucun film disponible pour votre tranche d'âge."];
    }
    $limite = time() - 604800;
    $category = [];
    for ($i = 0; $i < count($movies); $i++) {
        $movies[$i]->is_new = 0;
        if (isset($movies[$i]->date_ajout)) {
            $dateDuFilm = strtotime($movies[$i]->date_ajout);
            if ($dateDuFilm >= $limite) {
                $movies[$i]->is_new = 1;
            }
        }
        $label = $movies[$i]->label;
        $category[$label][] = $movies[$i];
    }
    return $category;
}
function addMoviesController(){
    $t = $_REQUEST['titre'];
    $r = $_REQUEST['realisateur'];
    $y = $_REQUEST['annee'];
    $dur = $_REQUEST['duree'];
    $des = $_REQUEST['description'];
    $cat = $_REQUEST['categorie'];
    $img = $_REQUEST['cover'];
    $url = $_REQUEST['trailer'];
    $age = $_REQUEST['age_min'];
    $ok = addMovie($t, $r, $y, $dur, $des, $cat, $img, $url, $age);
    if($ok != 0){
        return "$t a été ajouté";
    }
    else{
        return false;
    }
}

function readMovieDetailController(){
if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $id_profile = $_REQUEST['profile'];
        $movie = getMovieDetail($id);
        $favori = readFavorite($id_profile, $id);
        $limite = time() - 604800;
        if ($favori > 0){
            $movie->isFavorite = true;
        }
        else{
            $movie->isFavorite = false;
        }
        $movie->is_new = 0;
        if (isset($movie->date_ajout)) {
            $dateDuFilm = strtotime($movie->date_ajout);
            if ($dateDuFilm >= $limite) {
                $movie->is_new = 1;
            }
        }
        return $movie;
    }
    return false;
}

function updateProfileController(){
    $name = $_REQUEST['name'];
    $url = $_REQUEST['avatar'];
    $age = $_REQUEST['age'];

    if(empty($url)){
        $url = "placeholderProfile.svg";
    }

    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $ok = updateProfile($id, $name, $url, $age);
        if($ok !== false){
            return "Le profil a été modifié avec succès.";
        }
        else{
            return false;
        }
    }
    else{
        $ok = addProfile($name, $url, $age);
        if($ok !==false){
            return "Le profile de $name a été ajouté";
        }
        else{
            return false;
        }
    }

}

function readAllProfilesController(){
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        return getProfilesPrefs($id);
    }
    return getAllProfiles();
}

function readFavoriteController(){
    $profile = $_REQUEST['profile'];
    $favorites = getAllFavorite($profile);

    if (empty($favorites)) {
        return ["error" => "Votre liste de favoris est vide."];
    }
    $limite = time() - 604800;
    for ($i = 0; $i < count($favorites); $i++) {
        $favorites[$i]->is_new = 0;
        if (isset($favorites[$i]->date_ajout)) {
            $dateDuFilm = strtotime($favorites[$i]->date_ajout);
            if ($dateDuFilm >= $limite) {
                $favorites[$i]->is_new = 1;
            }
        }
    }
    return $favorites;
}

function updateFavoriteController(){
    $profile = $_REQUEST['profile'];
    $movie = $_REQUEST['movie'];
    $verification = readFavorite($profile, $movie);
    
    if ($verification > 0){
        $ok = removeFavorite($profile, $movie);
        if($ok != 0){
            return "Retiré de la liste des favoris";
        }
        return "Erreur";
    }
    $ok = addFavorite($profile, $movie);
    
    if($ok != 0){
        return "Ajouté à la liste des favoris";
    }
    return "Erreur";
}

function readHighlightController(){
    $min_age = $_REQUEST['min_age'];
    $highlights = getHighlightMovies($min_age);

    if (empty($highlights)) {
        return ["error" => "Aucun film mis en avant pour le moment."];
    }
    $limite = time() - 604800;
    for ($i = 0; $i < count($highlights); $i++) {
        $highlights[$i]->is_new = 0;
        if (isset($highlights[$i]->date_ajout)) {
            $dateDuFilm = strtotime($highlights[$i]->date_ajout);
            if ($dateDuFilm >= $limite) {
                $highlights[$i]->is_new = 1;
            }
        }
    }
    return $highlights;
}
    
function readStatsMoviesController() {
    return [
        getNbMovies(),
        getMostFavoritedMovie(),
        getMostPopularCategory(),
        getLatestMovie(),
        getBestMovie()
    ];
}
function readStatsUsersController() {
    return [
        getNbProfiles(),
        getAvgFavorites(),
        getActiveProfile(),
        getNbComment(),
        getNbCommentApproved(),
        getNbCommentPending()
    ];
}

function readSearchmoviesController() {
    if(isset($_REQUEST['id'])){
        $min_age = $_REQUEST['min_age'];
    }
    else{
        $min_age = 999;
    }
    $searchValue = $_REQUEST['searchvalue'];
    $resultas = getSearchmovies($min_age, $searchValue);
    if (empty($resultas)) {
        return ["error" => "Aucun film ne correspond à votre recherche."];
    }
    $limite = time() - 604800;
    for ($i = 0; $i < count($resultas); $i++) {
        $resultas[$i]->is_new = 0;
        if (isset($resultas[$i]->date_ajout)) {
            $dateDuFilm = strtotime($resultas[$i]->date_ajout);
            if ($dateDuFilm >= $limite) {
                $resultas[$i]->is_new = 1;
            }
        }
    }
    return $resultas;
}


function updateHighlightController(){
    $id = $_REQUEST['id'];
    $highlight = $_REQUEST['highlight'];

    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $ok = updateHighlight($id, $highlight);
        if($ok !== false){
            return "Le statut du film a été mis à jour";
        }
        else{
            return false;
        }
    }
}

function addNoteController(){
    $idmovie = $_REQUEST['idmovie'];
    $idprofile = $_REQUEST['idprofile'];
    $valeur = $_REQUEST['valeur'];
    $alreadyrated = getNoteMoviesProfile($idmovie, $idprofile);
    if (!$alreadyrated){
        $ok = addNoteMovies($idmovie, $idprofile, $valeur);
        if($ok != 0){
            return "Votre note a été enregistrée.";
        }
        else{
            return false;
        }
    }
    else{
        return "Vous avez déjà noté ce film.";
    }
}

function addCommentController(){
    $idmovie = $_REQUEST['idmovie'];
    $idprofile = $_REQUEST['idprofile'];
    $valeur = $_REQUEST['valeur'];
    if (!$idprofile) {
        return "Sélectionnez un profil";
    }  
    $ok = addCommentMovies($idmovie, $idprofile, $valeur);
    if($ok != 0){
        return "Votre commentaire a été enregistrée.";
    }
    else{
        return false;
    }
}

function readCommentController(){
    $movie = $_REQUEST['idmovie'];  
    $resultat = getCommentMovies($movie);    
    if (empty($resultat)) {
        return ["error" => "Aucun commentaire pour ce film. Soyez le premier à en laisser un !"];
    }    
    return $resultat;
}

function readCommentAdminController(){
    $resultat = getCommentAdmin();    
    if (empty($resultat)) {
        return ["error" => "Aucun commentaire à modérer pour le moment."];
    }    
    return $resultat;
}


function updateCommentAdminController(){
    $id = $_REQUEST['id'];
    $approved = $_REQUEST['approved'];

    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        if ($approved == 1){
            $ok = updateCommentAdmin($id, $approved);
            if($ok !== false){
                return "Le commentaire a été approuvé avec succès.";
            }
            else{
                return false;
            }
        }
        else if ($approved == 2){
            $ok = DeleteCommentAdmin($id);
            if($ok !== false){
                return "Le commentaire a été supprimé avec succès.";
            }
            else{
                return false;
            }
        }
    }
    return false;
}