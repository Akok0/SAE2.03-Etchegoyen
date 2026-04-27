let templateFile = await fetch("./component/Profiles/template.html");
let template = await templateFile.text();
let templateFileProfile = await fetch(
  "./component/Profiles/templateProfile.html",
);
let templateProfile = await templateFileProfile.text();

let Profiles = {};

Profiles.format = function (data, handler) {
  let html = template;

  let htmlProfile = "";
  for (let profileData of data) {
    let profile = templateProfile;
    profile = profile
      .replace("{{handler}}", handler)
      .replace("{{id}}", profileData.id)
      .replace("{{avatar}}", "../server/images/" + profileData.avatar)
      .replace("{{name}}", profileData.name);
    htmlProfile += profile;
  }
  html = html.replaceAll("{{profiles}}", htmlProfile);
  return html;
};

export { Profiles };
