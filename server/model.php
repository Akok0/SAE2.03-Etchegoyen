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


function getAllMovies($min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name,  Movie.image, Movie.id_category, Movie.date_ajout ,Category.name AS label, ROUND(AVG(Note.valeur), 1) AS note
            FROM Movie 
            INNER JOIN Category ON Category.id = Movie.id_category 
            LEFT JOIN Note ON Note.id_movie = Movie.id 
            WHERE min_age <= :min_age
            GROUP BY Movie.id
            ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function getAllCategories()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name FROM Category";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addMovie($t, $r, $y, $dur, $des, $cat, $img, $url, $age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
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
function addProfile($name, $url, $age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
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

function getMovieDetail($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Category.name AS label, Movie.*, ROUND(AVG(Note.valeur), 1) AS note 
            FROM Movie 
            INNER JOIN Category ON Category.id = Movie.id_category
            LEFT JOIN Note ON Note.id_movie = Movie.id
            WHERE Movie.id = :id
            GROUP BY Movie.id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function getAllProfiles()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "select * from Profile";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}
function getProfilesPrefs($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "select * from Profile WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function updateProfile($id, $name, $url, $age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
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


function readFavorite($profile, $movie)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT * FROM Favorite WHERE id_profile = :profile AND id_movie = :movie";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function getAllFavorite($profile)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.*, ROUND(AVG(Note.valeur), 1) AS note FROM Movie 
            INNER JOIN Favorite ON Movie.id = Favorite.id_movie 
            LEFT JOIN Note ON Note.id_movie = Movie.id
            WHERE Favorite.id_profile = :profile
            GROUP BY Movie.id";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);

    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addFavorite($profile, $movie)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Favorite (id_profile, id_movie) 
            VALUES (:profile, :movie)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}
function removeFavorite($profile, $movie)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Favorite WHERE id_profile = :profile AND id_movie = :movie";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':movie', $movie);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function getHighlightMovies($min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image, Movie.id_category, Movie.description, Movie.date_ajout, Category.name AS label, ROUND(AVG(Note.valeur), 1) AS note
            FROM Movie
            INNER JOIN Category ON Category.id = Movie.id_category
            LEFT JOIN Note ON Note.id_movie = Movie.id
            WHERE min_age <= :min_age AND highlight = 1
            GROUP BY Movie.id
            ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function getNbMovies()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Total des films' AS name, COUNT(*) AS value FROM Movie";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function getMostFavoritedMovie()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Film le plus favori' AS name, Movie.name AS value
            FROM Favorite 
            JOIN Movie ON Favorite.id_movie = Movie.id 
            GROUP BY Movie.id 
            ORDER BY COUNT(Favorite.id_movie) DESC 
            LIMIT 1";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getMostPopularCategory()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Catégorie la plus populaire' AS name, Category.name AS value 
            FROM Favorite 
            JOIN Movie ON Favorite.id_movie = Movie.id 
            JOIN Category ON Movie.id_category = Category.id 
            GROUP BY Category.id 
            ORDER BY COUNT(Favorite.id_movie) DESC 
            LIMIT 1";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getNbProfiles()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Total des profils créés' AS name, COUNT(*) AS value FROM Profile";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function getLatestMovie()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Film le plus récent' AS name, name as value, date_ajout FROM Movie ORDER BY date_ajout DESC LIMIT 1";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getBestMovie()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Film le mieux noté' AS name, Movie.name as value, ROUND(AVG(Note.valeur), 1) as avg_note
            FROM Movie INNER JOIN Note ON Note.id_movie = Movie.id
            GROUP BY Movie.id
            ORDER BY avg_note DESC LIMIT 1";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getActiveProfile()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Profil le plus actif' AS name, Profile.name as value, COUNT(Favorite.id_profile) + COUNT(Note.id_profile) as total
            FROM Profile 
            INNER JOIN Favorite ON Favorite.id_profile = Profile.id
            INNER JOIN Note ON Note.id_profile = Profile.id
            GROUP BY Profile.id
            ORDER BY total DESC LIMIT 1";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getNbComment()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Nombre de commentaires' as name, COUNT(*) as value
            FROM Comment";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}
function getNbCommentApproved()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Nombre de commentaires approuvé' as name, SUM(CASE WHEN approved = 1 THEN 1 ELSE 0 END) as value
            FROM Comment";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}
function getNbCommentPending()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Nombre de commentaires en attente' as name, SUM(CASE WHEN approved = 0 THEN 1 ELSE 0 END) as value
            FROM Comment";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getAvgFavorites()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 'Moyenne de favoris par profil' AS name, ROUND(AVG(fav_count)) AS value 
            FROM (
                SELECT COUNT(Favorite.id_movie) AS fav_count 
                FROM Profile 
                LEFT JOIN Favorite ON Favorite.id_profile = Profile.id 
                GROUP BY Profile.id
            ) AS avgResult";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getSearchmovies($min_age, $searchValue)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name,  Movie.image, Movie.id_category, Movie.highlight, Movie.date_ajout, Category.name AS label FROM Movie INNER JOIN Category ON Category.id = Movie.id_category WHERE min_age <= :min_age AND (LOWER(Movie.name) LIKE :searchvalue OR LOWER(Category.name) LIKE :searchvalue OR Movie.year LIKE :searchvalue) ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $search = "%" . strtolower($searchValue) . "%";
    $stmt->bindParam(':min_age', $min_age);
    $stmt->bindParam(':searchvalue', $search);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function updateHighlight($id, $highlight)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Movie SET highlight = :highlight WHERE id = :id;";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':highlight', $highlight);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}


function getNoteMoviesProfile($idmovie, $idprofile)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT valeur FROM Note WHERE id_movie = :idmovie AND id_profile = :idprofile";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':idmovie', $idmovie);
    $stmt->bindParam(':idprofile', $idprofile);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function addNoteMovies($idmovie, $idprofile, $valeur)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Note (id_movie, id_profile, valeur) 
            VALUES (:idmovie, :idprofile, :valeur)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':idmovie', $idmovie);
    $stmt->bindParam(':idprofile', $idprofile);
    $stmt->bindParam(':valeur', $valeur);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getCommentMovies($idmovie)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comment.content, Comment.date_comment, Profile.name AS name FROM Comment
            INNER JOIN Profile ON Profile.id = Comment.id_profile 
            WHERE id_movie = :idmovie AND Comment.approved = 1
            ORDER BY Comment.date_comment DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':idmovie', $idmovie);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
function addCommentMovies($idmovie, $idprofile, $valeur)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Comment (id_movie, id_profile, content) 
            VALUES (:idmovie, :idprofile, :valeur)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':idmovie', $idmovie);
    $stmt->bindParam(':idprofile', $idprofile);
    $stmt->bindParam(':valeur', $valeur);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getCommentAdmin()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Comment.id, Comment.approved, Comment.content, Comment.date_comment, Profile.name AS name FROM Comment
            INNER JOIN Profile ON Profile.id = Comment.id_profile 
            WHERE Comment.approved = 0
            ORDER BY Comment.date_comment DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function updateCommentAdmin($id, $approved)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Comment SET approved = :approved WHERE id = :id;";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':approved', $approved);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function DeleteCommentAdmin($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Comment WHERE id = :id;";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}