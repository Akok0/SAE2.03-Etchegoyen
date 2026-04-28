let templateFile = await fetch("./component/ProfileForm/template.html");
let template = await templateFile.text();
let templateFileProfile = await fetch("./component/ProfileForm/templateProfile.html");
let templateProfile = await templateFileProfile.text();

let ProfileForm = {};

ProfileForm.format = function (data, handlerUpdate, handlerSelect) {
  let html = template;
  html = html.replace("{{handlerUpdate}}", handlerUpdate)
              .replace("{{handlerSelect}}", handlerSelect);


  let htmlProfile = "";
  for (let profileData of data) {
    let profile = templateProfile;
    profile = profile
      .replace("{{id}}", profileData.id)
      .replace("{{name}}", profileData.name);
    htmlProfile += profile;
  }
  html = html.replaceAll("{{profiles}}", htmlProfile);
  return html;
};

export { ProfileForm };
