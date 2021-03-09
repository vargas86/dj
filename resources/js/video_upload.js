import Swal from 'sweetalert2'

var el = _("video");

el.addEventListener("change", function (e) {
    uploadFile();
});

function uploadFile() {
    var file = el.files[0];
    if (!file) return false;

    appendProgressBar();

    var formData = new FormData();
    formData.append("video", file);

    var ajax = new XMLHttpRequest();
    var token = document.getElementsByName('csrf-token')[0].content;

    ajax.upload.addEventListener("progress", progressHandler, false);
    // ajax.upload.addEventListener("load", completeHandler, false);
    ajax.upload.addEventListener("error", errorHandler, false);
    if (section_id !== undefined && course_slug !== undefined) {
        ajax.open("POST", "/member/channel/videos/upload/" + course_slug + '/' + section_id);
    } else {
        ajax.open("POST", "/member/channel/videos/upload");
    }
    ajax.setRequestHeader("X-CSRF-Token", token);

    ajax.send(formData);
    ajax.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 422) {
                let errormsg = JSON.parse(this.responseText);
                ajax_progress = document.getElementById("ajax_progress");
                if (error = ajax_progress.querySelector(".ajax-error"))
                    ajax_progress.removeChild(error);
                var error = document.createElement("div");
                error.classList.add("ajax-error");
                error.innerHTML = "<i class='uil uil-info-circle'></i><small>" + errormsg + "</small>";
                _("ajax_progress").appendChild(error);
            }
            if (this.status === 413) {
                ajax_progress = document.getElementById("ajax_progress");
                if (error = ajax_progress.querySelector(".ajax-error"))
                    ajax_progress.removeChild(error);
                var error = document.createElement("div");
                error.classList.add("ajax-error");
                error.innerHTML = "<i class='uil uil-info-circle'></i><small>File too large !</small>";
                _("ajax_progress").appendChild(error);
            }
            if (this.status === 200) {
                let response = JSON.parse(this.response);
                let slug = response.video_slug;
                if (slug !== undefined && section_id !== undefined && course_slug !== undefined) {
                    window.location.replace("/member/channel/videos/" + slug + "/edit/" + course_slug + '/' + section_id);
                } else if (slug !== undefined) {
                    window.location.replace("/member/channel/videos/" + slug + "/edit");
                }
            }
        }
    };

}

function progressHandler(event) {
    var percent = Math.round((event.loaded / event.total) * 100) + "%";
    _("progress_bar").style.width = percent;
}

function completeHandler(event) {
    var success = document.createElement("div");
    success.classList.add("ajax-success");
    success.innerHTML = "<i class='uil uil-check-circle'></i><small>Processing...</small>";
    _("ajax_progress").appendChild(success);
}

function errorHandler(event) {
    var error = document.createElement("div");
    error.classList.add("ajax-error");
    error.innerHTML = "<i class='uil uil-info-circle'></i><small>There was an error uploading your video</small>";
    _("ajax_progress").appendChild(error);
}

function appendProgressBar() {
    ajax_progress = document.getElementById("ajax_progress");
    if (progress = ajax_progress.querySelector(".progress"))
        ajax_progress.removeChild(progress);
    var progress = document.createElement("div");
    progress.classList.add("progress");
    _("ajax_progress").appendChild(progress);

    var innerProgress = document.createElement("div");
    innerProgress.classList.add("bar");
    innerProgress.id = "progress_bar";
    progress.appendChild(innerProgress);

}


function _(el) {
    return document.getElementById(el);
}

// delete channel
if (document.getElementById('delete_channel')) {
    document.getElementById('delete_channel').addEventListener('click', (e) => {
        e.preventDefault();
        let redirect = e.target.href;
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete your channel ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'Your channel has been delete.',
                    'success'
                );
                window.location = redirect;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    '',
                    'error'
                )
            }
        })

    });
}
// delete channel
if (document.getElementsByClassName('close')) {
    let list = document.getElementsByClassName('close');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to cancel this operation ?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var modal = document.getElementById("myModal");
                    var video = document.getElementById('video');
                    var ajax_progress = document.getElementById("ajax_progress");
                    var progress = ajax_progress.querySelector(".progress");
                    var success = ajax_progress.querySelector(".ajax-success");
                    var error = ajax_progress.querySelector(".ajax-error");

                    modal.style.display = "none";
                    video.value = null;

                    if (progress)
                        ajax_progress.removeChild(progress);
                    if (success)
                        ajax_progress.removeChild(success);
                    if (error)
                        ajax_progress.removeChild(error);

                }
            })

        });
    });
}

// delete video
if (document.getElementsByClassName('delete_video')) {
    let list = document.getElementsByClassName('delete_video');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this video ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'The video has been deleted.',
                        'success'
                    );
                    window.location = redirect;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        '',
                        'error'
                    )
                }
            })
        });
    });
}
// delete video
if (document.getElementsByClassName('delete_video_icon')) {
    let list = document.getElementsByClassName('delete_video_icon');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.parentNode.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this video ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'The video has been deleted.',
                        'success'
                    );
                    window.location = redirect;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        '',
                        'error'
                    )
                }
            })
        });
    });
}

