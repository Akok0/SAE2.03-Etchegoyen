let templateFile = await fetch("./component/Stats/template.html");
let template = await templateFile.text();
let templateFileStats = await fetch("./component/Stats/templateStat.html");
let templateStats = await templateFileStats.text();

let Stats = {};

Stats.format = function (dataFilms, dataUsers) {
  let html = template;
  let htmlStatsFilms = "";
  for (let stat of dataFilms){
    let statCard = templateStats;
    statCard = statCard.replaceAll("{{nb}}", stat.value)
                        .replaceAll("{{desc}}", stat.name);
    htmlStatsFilms += statCard;
  }
  let htmlStatsUsers = "";
  for (let stat of dataUsers){
    let statCard = templateStats;
    statCard = statCard.replaceAll("{{nb}}", stat.value)
                        .replaceAll("{{desc}}", stat.name);
    htmlStatsUsers += statCard;
  }
  html = html
    .replace("{{stats_films}}", htmlStatsFilms)
    .replace("{{stats_users}}", htmlStatsUsers)
  return html;
};

export { Stats };
