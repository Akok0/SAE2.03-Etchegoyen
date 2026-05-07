let templateFile = await fetch("./component/MovieFavorite/template.html");
let template = await templateFile.text();

let MovieFavorite = {};

MovieFavorite.format = function (data) {
    let html = template.replaceAll("{{title}}", "Votre liste")
                        .replaceAll("{{movies}}", data);
    return html;
};

export { MovieFavorite };