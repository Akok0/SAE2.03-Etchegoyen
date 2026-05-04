let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();
let templateFileComment = await fetch("./component/MovieDetail/templateComment.html");
let templateComment = await templateFileComment.text();

let MovieDetail = {};

MovieDetail.format = function (data, handlerFavorite, handlerclose, handlerNote , dataComment, handlerComment) {
  let html = template;
  html = html.replaceAll("{{title}}", data.name)
  .replaceAll("{{cover}}", "../server/images/" + data.image)
  .replaceAll("{{realisateur}}", data.director)
  .replaceAll("{{year}}", data.year)
  .replaceAll("{{categorie}}", data.label)
  .replaceAll("{{description}}", data.description)
  .replaceAll("{{age}}", data.min_age)
  .replaceAll("{{note}}", data.note)
  .replaceAll("{{trailer}}", data.trailer)

  .replaceAll("{{handlerFavorite}}", handlerFavorite)
  .replaceAll("{{handlerclose}}", handlerclose)
  .replaceAll("{{handlerNote}}", handlerNote)
  .replaceAll("{{handlerComment}}", handlerComment);
    if (data.is_new == 1){
      html = html.replaceAll("{{new}}", "NEW");
    }
    else{
      html = html.replaceAll("{{new}}", "");
    }

let htmlComment = "";
  let message = "";
  
  if (dataComment && dataComment.error) {
    message = dataComment.error;
  }
  if (!dataComment || dataComment.error || dataComment.length == 0) {
    htmlComment = "<li class='movies__error'>" + message + "</li>";
  }
  else{
  for (let comments of dataComment){
    let comment = templateComment;
    comment = comment.replaceAll("{{name}}", comments.name)
                      .replaceAll("{{date}}", comments.date_comment)
                      .replaceAll("{{content}}", comments.content);
    htmlComment += comment;
  }
}
  html = html.replaceAll("{{comment}}", htmlComment)
  return html
};

export { MovieDetail };
