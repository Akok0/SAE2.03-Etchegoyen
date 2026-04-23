let templateFile = await fetch("./component/Movies/template.html");
let templateFileMovie = await fetch("./component/Movies/templateMovie.html");
let template = await templateFile.text();
let templateMovie = await templateFileMovie.text();

let Movies = {};

Movies.format = function (data, tab) {
  let html = template;
  if (data.length == 0) {
    html = html.replace("{{movie}}", "<p class='movies__error'>Aucun film disponible pour le moment.</p>");
  }
  else {
    let htmlMovie = "";
    for (let movie of data) {
      let card = templateMovie;
      card = card
        .replaceAll("{{name}}", movie.name)
        .replaceAll("{{image}}", "../server/images/" + movie.image);
      htmlMovie += card;
    }
    html = html.replace("{{movie}}", htmlMovie);
  }
  return html
};

export { Movies };
