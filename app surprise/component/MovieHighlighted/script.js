let templateFile = await fetch("./component/MovieHighlighted/template.html");
let template = await templateFile.text();

let MoviesHighlighted = {};

MoviesHighlighted.format = function (data) {
    let html = template.replaceAll("{{title}}", "Films mis en avant")
                        .replaceAll("{{movies}}", data);
    return html;
};

export { MoviesHighlighted };