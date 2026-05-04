let templateFile = await fetch("./component/Movies/template.html");
let templateFileMovie = await fetch("./component/Movies/templateMovie.html");
let template = await templateFile.text();
let templateMovie = await templateFileMovie.text();

let Movies = {};

Movies.format = function (data, handler, error) {
  let html = template;
  let message = "";
  if (data && data.error) {
    message = data.error;
  } else {
    message = "Aucun film disponible pour le moment.";
  }
  if (!data || data.error || data.length == 0) {
    html = html.replace("{{movie}}", "<p class='movies__error'>" + message + "</p>");
  } 
  else {
    let htmlMovie = "";
    for (let movie of data) {
      let card = templateMovie;
      card = card
        .replaceAll("{{name}}", movie.name)
        .replaceAll("{{image}}", "../server/images/" + movie.image)
        .replaceAll("{{handler}}", handler)
        .replaceAll("{{id}}", movie.id);
        if (movie.note){
          card = card.replaceAll("{{note}}", movie.note);
        }
        else{
          card = card.replaceAll("{{note}}", "");
        }
        if (movie.is_new == 1){
          card = card.replaceAll("{{new}}", "NEW");
        }
        else{
          card = card.replaceAll("{{new}}", "");
        }

      htmlMovie += card;
    }
    html = html.replace("{{movie}}", htmlMovie);
  }
  return html
};

export { Movies };
