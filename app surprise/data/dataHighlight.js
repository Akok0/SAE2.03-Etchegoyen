let HOST_URL = "..";

let DataHighlight = {};

DataHighlight.requestHighlight = async function(min_age = 0){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readhighlight&min_age=" + min_age);
    let data = await answer.json();
    return data;
}

export {DataHighlight};