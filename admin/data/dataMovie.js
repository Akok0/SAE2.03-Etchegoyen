// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "https://mmi.unilim.fr/~etchegoyen3/SAE2.03-Etchegoyen"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

DataMovie.requestCategories = async function(){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readcategory");
    let data = await answer.json();
    return data;
}

DataMovie.addmovies = async function(fdata){
    let config = {
        method: "POST",
        body: fdata
    };
    let anwser = await fetch(HOST_URL + "/server/script.php?todo=addmovies", config)
    let data = await anwser.json();
    return data;
}

export {DataMovie};
