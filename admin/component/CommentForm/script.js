let templateFile = await fetch("./component/CommentForm/template.html");
let template = await templateFile.text();
let templateFileComment = await fetch("./component/CommentForm/templateComment.html");
let templateComment = await templateFileComment.text();

let CommentForm = {};

CommentForm.format = function (data, handlerApprove, handlerDelete) {
    let html = template;
    let htmlComment = "";
    let message = "";
    
    if (data && data.error) {
        message = data.error;
    }
    if (!data || data.error || data.length == 0) {
        htmlComment = "<li class='movies__error'>" + message + "</li>";
    }
    else{
    for (let comments of data){
        let comment = templateComment;
        comment = comment.replaceAll("{{name}}", comments.name)
                        .replaceAll("{{date}}", comments.date_comment)
                        .replaceAll("{{content}}", comments.content)
                        .replaceAll("{{handlerApprove}}", handlerApprove + "(" + comments.id + "," + comments.approved + ")")
                        .replaceAll("{{handlerDelete}}", handlerDelete + "(" + comments.id + "," + comments.approved + ")");
        htmlComment += comment;
    }
    }
    html = html.replaceAll("{{comment}}", htmlComment)
    return html
    };

export { CommentForm };
