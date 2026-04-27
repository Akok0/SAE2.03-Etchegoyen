let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, handlerListe, handlerLogOut, data) {
  let html = template;

  html = html.replace("{{hAbout}}", hAbout)
        .replaceAll("{{handlerListe}}", handlerListe)
      .replace("{{handlerLogOut}}", handlerLogOut)
      .replace("{{avatar}}", "../server/images/" + data.avatar)
      .replace("{{name}}", data.name);
  return html;
};

export { NavBar };
