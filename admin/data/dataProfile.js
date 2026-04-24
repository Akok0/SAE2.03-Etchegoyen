let HOST_URL = "https://mmi.unilim.fr/~etchegoyen3/SAE2.03-Etchegoyen"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataProfile = {};

DataProfile.addprofile = async function(fdata){
    let config = {
        method: "POST",
        body: fdata
    };
    let anwser = await fetch(HOST_URL + "/server/script.php?todo=addprofile", config)
    let data = await anwser.json();
    return data;
}

export {DataProfile};