let templateFile = await fetch("./component/MovieForm/template.html");
let template = await templateFile.text();
let templateFileOption = await fetch("./component/MovieForm/templateOption.html");
let templateOption = await templateFileOption.text();

let MovieForm = {};

MovieForm.format = function (data, handler) {
  let html = template;
    html = html.replace("{{handler}}", handler);
    let htmlOption = "";
for (let category of data) {
      let option = templateOption;
      option = option.replaceAll("{{option__id}}", category.id)
                     .replaceAll("{{option__name}}", category.name);
                     
      htmlOption += option;
  }
    html = html.replaceAll("{{option}}", htmlOption);
  return html
};

export { MovieForm };
