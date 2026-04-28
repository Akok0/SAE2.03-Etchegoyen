// URL où se trouve le répertoire "server" sur mmi.unilim.fr
//let HOST_URL = "https://mmi.unilim.fr/~etchegoyen3/SAE2.03-Etchegoyen"; // CHANGE THIS TO MATCH YOUR CONFIG
let HOST_URL = "../";

let DataMovie = {};

DataMovie.requestMovies = async function(min_age = 0){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies&min_age=" + min_age);
    let data = await answer.json();
    return data;
}

DataMovie.requestMovieDetails = async function(id){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovieDetail&id=" + id);
    let data = await answer.json();
    return data;
}

export {DataMovie};
