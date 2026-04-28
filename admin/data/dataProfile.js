//let HOST_URL = "https://mmi.unilim.fr/~etchegoyen3/SAE2.03-Etchegoyen"; // CHANGE THIS TO MATCH YOUR CONFIG
let HOST_URL = "../";

let DataProfile = {};

DataProfile.updateprofiles = async function(fdata){
    let config = {
        method: "POST",
        body: fdata
    };
    let anwser = await fetch(HOST_URL + "/server/script.php?todo=updateprofile", config)
    let data = await anwser.json();
    return data;
}   

DataProfile.requestProfiles = async function(id = null){
    let url = "/server/script.php?todo=readprofiles";
    if (id){
        url += "&id=" + id;
    }
    let answer = await fetch(HOST_URL + url);
    let data = await answer.json();
    return data;
}

export {DataProfile};