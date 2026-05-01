let templateFile = await fetch("./component/MovieSearchForm/template.html");
let templateFileMovie = await fetch(
  "./component/MovieSearchForm/templateMovie.html",
);
let template = await templateFile.text();
let templateMovie = await templateFileMovie.text();

let MovieSearchForm = {};

MovieSearchForm.formatSearchBar = function (handlerSearch) {
  return template.replaceAll("{{handlerSearch}}", handlerSearch);
};

MovieSearchForm.formatResults = function (data, handlertoggle) {
  let message;
  if (data && data.error) {
    message = data.error;
  } else {
    message = "Aucun film ne correspond à la recherche";
  }
  if (!data || data.error || data.length == 0) {
    return "<li class='error'>" + message + "</li>";
  }

  let htmlMovies = "";
  for (let movie of data) {
    let movies = templateMovie;

    let newStatus;
    let checked;

    if (movie.highlight == 1) {
      status = 0;
      checked = "checked";
    } else {
      status = 1;
      checked = "";
    }

    movies = movies
      .replaceAll("{{title}}", movie.name)
      .replaceAll("{{category}}", movie.label)
      .replaceAll("{{checked}}", checked)
      .replaceAll(
        "{{handlerToggle}}",
        handlertoggle + "(" + movie.id + ", " + status + ")",
      );

    htmlMovies += movies;
  }

  return htmlMovies;
};

export { MovieSearchForm };
