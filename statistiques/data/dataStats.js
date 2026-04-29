let HOST_URL = "..";

let DataStats = {};

DataStats.requestStatsmovies = async function(){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readstatsmovies");
    let data = await answer.json();
    return data;
}
DataStats.requestStatsusers = async function(){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readstatsusers");
    let data = await answer.json();
    return data;
}

export { DataStats }