import Viewer from 'viewerjs';
import Swal from 'sweetalert2'


function _(el) {
    return document.getElementById(el);
}
function completeHandler(event) {
    var success = document.createElement("div");
    success.classList.add("ajax-success");
    success.innerHTML = "<i class='uil uil-check-circle'></i><small>Upload complete</small>";
    _("bar").appendChild(success);
}
function errorHandler(event) {
    var error = document.createElement("div");
    error.classList.add("ajax-error");
    error.innerHTML = "<i class='uil uil-info-circle'></i><small>There was an error uploading your video</small>";
    _("bar").appendChild(error);
}

function progressHandler(event) {
    var percent = (Math.round((event.loaded / event.total) * 100) - 10) + "%";
    _("bar").style.width = percent;
}

function appendProgressBar() {
    var progress = document.createElement("li");
    progress.classList.add("uploading");
    progress.id = "gallery_add";
    var progress_div = document.createElement("div");
    progress_div.classList.add("progress");
    var bar_div = document.createElement("div");
    bar_div.classList.add('bar');
    bar_div.id = "bar";
    progress_div.appendChild(bar_div);
    progress.appendChild(progress_div);
    bar_div.style.width = '10%';
    _("gallery_items").removeChild(_("gallery_add"));
    _("gallery_items").appendChild(progress);

}



const gallery = new Viewer(document.getElementById('gallery_items'), {
    url(image) {
        let path = image.src.split('galleries/')[0] + "galleries/" + "full_" + image.src.split('galleries/')[1];
        return path
    }
});

var button = document.getElementById("gallery_add");
var input = document.getElementById("gallery_file");
button.addEventListener("click", function (e) {
    input.click();
});

var change_listener = function (e) {
    let ajax_progress = document.getElementById("gallery_items");
    if (ajax_progress.querySelector(".ajax-error"))
        ajax_progress.removeChild(ajax_progress.querySelector(".ajax-error"));
    if (input == null) {
        input = document.getElementById("gallery_file");
    }
    appendProgressBar();
    var token = document.getElementsByName('csrf-token')[0].content;
    var ajax = new XMLHttpRequest();

    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.upload.addEventListener("load", completeHandler, false);
    ajax.upload.addEventListener("error", errorHandler, false);

    var formData = new FormData();
    formData.append("gallery_file", input.files[0]);
    ajax.open("POST", "/member/profile/gallery", true);
    ajax.setRequestHeader("X-CSRF-Token", token);
    ajax.send(formData);
    ajax.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 422) {

                if (_('gallery_add').querySelector('.progress')) {
                    _('gallery_add').removeChild(_('gallery_add').querySelector('.progress'));
                }
                _('gallery_add').classList.remove('uploading');
                _('gallery_add').classList.add('add-gallery');
                input = null;
                var file_input = document.createElement("input");
                file_input.type = 'file';
                file_input.name = "gallery_file";
                file_input.id = "gallery_file";

                _('gallery_add').appendChild(file_input);
                var button = document.getElementById("gallery_add");
                console.log(_("gallery_file"));
                button.addEventListener("click", function (e) {
                    file_input.click();
                });
                file_input.addEventListener("change", change_listener);
                let errormsg = JSON.parse(this.responseText);
                var error = document.createElement("div");
                error.classList.add("ajax-error");
                error.innerHTML = "<i class='uil uil-info-circle'></i><small>" + errormsg + "</small>";
                ajax_progress.appendChild(error);
            }
            if (this.status == 413) {
                if (_('gallery_add').querySelector('.progress')) {
                    _('gallery_add').removeChild(_('gallery_add').querySelector('.progress'));
                }
                _('gallery_add').classList.remove('uploading');
                _('gallery_add').classList.add('add-gallery');
                input = null;
                var file_input = document.createElement("input");
                file_input.type = 'file';
                file_input.name = "gallery_file";
                file_input.id = "gallery_file";

                _('gallery_add').appendChild(file_input);
                var button = document.getElementById("gallery_add");
                console.log(_("gallery_file"));
                button.addEventListener("click", function (e) {
                    file_input.click();
                });
                file_input.addEventListener("change", change_listener);
                var error = document.createElement("div");
                error.classList.add("ajax-error");
                error.innerHTML = "<i class='uil uil-info-circle'></i><small>File too large!</small>";
                ajax_progress.appendChild(error);
            }
            if (this.status === 200) {
                location.reload();
            }
        }
    };
};

input.addEventListener("change", change_listener);

document.body.addEventListener('click', (e) => {
    // this js for deleting photo in gallery
    if(!e.target.classList.contains("delete")) return false;
    e.preventDefault();
    let redirect = e.target.href;
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this picture ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Deleted!',
                'The picture has been delete.',
                'success'
            );
            var token = document.getElementsByName('csrf-token')[0].content;
            var ajax = new XMLHttpRequest();
            ajax.responseType = 'json';
            ajax.open("GET", "/member/profile/gallery/remove/" + e.target.id, true);
            ajax.setRequestHeader("X-CSRF-Token", token);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    location.reload();
                }
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                '',
                'error'
            )
        }
    });
    
});