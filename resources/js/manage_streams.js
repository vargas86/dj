var shareViewerCamEl = document.querySelectorAll(".shareViewerCam");
var stopSharedCamEl = _("stopSharedCam");
var endStreamEl = _("endStream");

endStreamEl.addEventListener("click", function(e) {
    endStream();
});
stopSharedCamEl.addEventListener("click", function(e) {
    stopSharedCam();
});
shareViewerCamEl.forEach(function(element) {
    element.addEventListener("click", function() {
        shareViewerCam();
    });
});


function endStream() {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "/member/channel/end_stream");
    ajax.send();
    ajax.onload = function() {

    };
    ajax.onerror = function() {

    };
}

function stopSharedCam() {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "/member/channel/stop_shared_cam");
    ajax.send();
    ajax.onload = function() {

    };
    ajax.onerror = function() {

    };
}

function shareViewerCam() {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "/member/channel/share_viewer_cam");
    ajax.send();
    ajax.onload = function() {

    };
    ajax.onerror = function() {

    };
}

function _(el) {
    return document.getElementById(el);
}