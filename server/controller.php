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
    $category = [];
    for ($i = 0; $i < count($movies); $i++) {
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
        if ($favori > 0){
            $movie->isFavorite = true;
        }
        else{
            $movie->isFavorite = false;
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
    return getAllFavorite($profile);
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
    return getHighlightMovies($min_age);
}

function readStatsMoviesController(){
    return getStatsMovies();
}
function readStatsUsersController(){
    return getStatsUsers();
}