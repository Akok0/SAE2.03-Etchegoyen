<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "etchegoyen3");
define("DBLOGIN", "etchegoyen3");
define("DBPWD", "etchegoyen3");


function getAllMovies($min_age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select Movie.id, Movie.name,  Movie.image, Movie.id_category, Category.name as label from Movie INNER JOIN Category ON Category.id = Movie.id_category WHERE min_age <= :min_age ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function getAllCategories() {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name FROM Category"; 
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addMovie($t, $r, $y, $dur, $des, $cat, $img, $url, $age) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:t, :r, :y, :dur, :des, :cat, :img, :url, :age)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':t', $t);
    $stmt->bindParam(':r', $r);
    $stmt->bindParam(':y', $y);
    $stmt->bindParam(':dur', $dur);
    $stmt->bindParam(':des', $des);
    $stmt->bindParam(':cat', $cat);
    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':age', $age);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}
function addProfile($name, $url, $age) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Profile (name, avatar, min_age) 
            VALUES (:name, :url, :age)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':age', $age);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function getMovieDetail($id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select Category.name as label, Movie.* from Movie INNER JOIN Category ON Category.id = Movie.id_category WHERE Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function getAllProfiles(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select * from Profile";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}
function getProfilesPrefs($id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select * from Profile WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function updateProfile($id, $name, $url, $age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Profile SET name = :name, avatar = :url, min_age = :age WHERE id = :id;";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':age', $age);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}


function readFavorite($profile, $movie) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT * FROM Favorite WHERE id_profile = :profile AND id_movie = :movie";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function getAllFavorite($profile) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.* FROM Movie INNER JOIN Favorite ON Movie.id = Favorite.id_movie WHERE Favorite.id_profile = :profile";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);

    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addFavorite($profile, $movie) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Favorite (id_profile, id_movie) 
            VALUES (:profile, :movie)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}
function removeFavorite($profile, $movie) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Favorite WHERE id_profile = :profile AND id_movie = :movie";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function getHighlightMovies($min_age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image, Movie.id_category, Movie.description, Category.name as label from Movie INNER JOIN Category ON Category.id = Movie.id_category WHERE min_age <= :min_age AND highlight = 1 ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}