let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (data, handlerFavorite) {
  let html = template;
  html = html.replaceAll("{{title}}", data.name)
  .replaceAll("{{cover}}", "../server/images/" + data.image)
  .replaceAll("{{realisateur}}", data.director)
  .replaceAll("{{year}}", data.year)
  .replaceAll("{{categorie}}", data.label)
  .replaceAll("{{description}}", data.description)
  .replaceAll("{{age}}", data.min_age)
  .replaceAll("{{trailer}}", data.trailer)

  .replaceAll("{{handlerFavorite}}", handlerFavorite);

  return html
};

export { MovieDetail };
