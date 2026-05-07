let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (categoryName, moviesHtml) {
    let html = template;
    html = html.replaceAll("{{titleCategory}}", categoryName)
               .replaceAll("{{movies}}", moviesHtml);
    return html;
};

export { MovieCategory };