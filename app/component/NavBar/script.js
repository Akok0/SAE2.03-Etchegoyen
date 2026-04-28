let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();
let templateFileProfile = await fetch(
  "./component/NavBar/templateProfile.html",
);
let templateProfile = await templateFileProfile.text();

let NavBar = {};

NavBar.format = function (hAbout, handlerListe, handlerSelect, data, handlerLogOut) {
  let html = template;

  html = html
    .replace("{{hAbout}}", hAbout)
    .replaceAll("{{handlerListe}}", handlerListe)
    .replaceAll("{{handlerSelect}}", handlerSelect)
    .replaceAll("{{handlerLogOut}}", handlerLogOut);
  let htmlProfile = "";
  for (let profileData of data) {
    let profile = templateProfile;
    profile = profile
      .replace("{{id}}", profileData.id)
      .replace("{{name}}", profileData.name);
    htmlProfile += profile;
  }
  html = html.replace("{{profiles}}", htmlProfile);
  return html;
};

export { NavBar };
