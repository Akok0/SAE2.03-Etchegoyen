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

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");


function readMoviesController(){
    $movies = getAllMovies();
    return $movies;
}
function readMoviesByCategoryController(){
    $movies = getAllMovies();
    $category = [];
    foreach($movies as $movie){
        $label = $movie->label;
        if (!isset($category[$label])){
            $category[$label] = [];
        }
        $category[$label][] = $movie;
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
        return getMovieDetail($id);
    }
    return false;
}