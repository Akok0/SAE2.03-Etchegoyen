let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, handler) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout)
        .replaceAll("{{handler}}", handler);
  return html;
};

export { NavBar };
