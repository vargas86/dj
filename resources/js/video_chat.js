
//Keep video and chat heights equal
var video = document.getElementById("video_main");
var chat = document.getElementById("video_chat");
document.addEventListener("DOMContentLoaded", adjustChatHeight);
window.addEventListener("resize", adjustChatHeight);
function adjustChatHeight() {
    chat.style.height = video.clientHeight + "px";
}

//Scroll to bottom
document.addEventListener("DOMContentLoaded", scrollToBottom);
function scrollToBottom() {
    var chatInner = document.getElementById("chat_inner")
    chatInner.scrollTo(0, chatInner.scrollHeight);
}


//Toggle overlay chat
var togglebtn = document.getElementById("chat_toggle");
togglebtn.addEventListener("click", function() {
    chat.classList.toggle("d-none");
    this.classList.toggle("uil-comment-alt-slash");
});