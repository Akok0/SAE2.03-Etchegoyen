let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();
let templateFileProfile = await fetch(
  "./component/NavBar/templateProfile.html",
);
let templateProfile = await templateFileProfile.text();


let NavBar = {};

NavBar.format = function (hAbout, handlerSelect, data, profileSelected, handlerLogOut, handlerDropdown, handlerSearch) {
  let html = template;

  html = html
    .replace("{{hAbout}}", hAbout)
    .replaceAll("{{handlerDropdown}}", handlerDropdown)
    .replaceAll("{{handlerSelect}}", handlerSelect)
    .replaceAll("{{handlerLogOut}}", handlerLogOut)
    .replaceAll("{{handlerSearch}}", handlerSearch);
    if (profileSelected != ""){
      html = html.replaceAll("{{name}}", profileSelected.name)
                .replaceAll("{{avatar}}", "../server/images/" + profileSelected.avatar);
    }
    else{
            html = html.replaceAll("{{name}}", "Choisir un profile")
                .replaceAll("{{avatar}}", "../server/images/placeholderProfile.svg");
    }

  let htmlProfile = "";
  for (let profileData of data) {
    let profile = templateProfile;
    profile = profile
      .replaceAll("{{id}}", profileData.id)
      .replaceAll("{{name}}", profileData.name)
      .replaceAll("{{avatar}}", "../server/images/" + profileData.avatar)
      .replaceAll("{{handler}}", handlerSelect);
    htmlProfile += profile;
  }
  html = html.replace("{{profiles}}", htmlProfile);
  return html;
};

export { NavBar };


