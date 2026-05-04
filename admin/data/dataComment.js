let HOST_URL = "..";

let DataComment = {};

DataComment.requestComment = async function(){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readcommentadmin");
    let data = await answer.json();
    return data;
}

DataComment.updatecomment = async function(fdata){
    let config = {
        method: "POST",
        body: fdata
    };
    let anwser = await fetch(HOST_URL + "/server/script.php?todo=updatecommentadmin", config)
    let data = await anwser.json();
    return data;
}

export {DataComment};
