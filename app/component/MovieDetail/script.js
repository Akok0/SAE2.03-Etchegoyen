let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (data, handlerFavorite, handlerclose, handlerNote) {
  let html = template;
  html = html.replaceAll("{{title}}", data.name)
  .replaceAll("{{cover}}", "../server/images/" + data.image)
  .replaceAll("{{realisateur}}", data.director)
  .replaceAll("{{year}}", data.year)
  .replaceAll("{{categorie}}", data.label)
  .replaceAll("{{description}}", data.description)
  .replaceAll("{{age}}", data.min_age)
  .replaceAll("{{note}}", data.note)
  .replaceAll("{{trailer}}", data.trailer)

  .replaceAll("{{handlerFavorite}}", handlerFavorite)
  .replaceAll("{{handlerclose}}", handlerclose)
  .replaceAll("{{handlerNote}}", handlerNote);

  return html
};

export { MovieDetail };
