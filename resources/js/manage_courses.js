import { ajax } from "jquery";
import Sortable from "sortablejs";
import Swal from 'sweetalert2'

if (document.getElementsByClassName('delete_section')) {
    let list = document.getElementsByClassName('delete_section');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.parentNode.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this section ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'The section has been deleted.',
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
//Video list sorting

var videolists = document.querySelectorAll(".video-list");
var lists = [];
videolists.forEach(el => {
    var list = new Sortable(el, {
        filter: ".ignore-drag",
        sort: true,
        group: "videos",
        onEnd(e) {
            var section_ids = [];
            section_ids = Array.prototype.map.call(document.getElementById("section_container").children, function (el) {
                return el;
            });
            section_ids.forEach((section) => {
                Array.prototype.map.call(section.children, (x) => {
                    if (x.className === 'video-list') {
                        for (let index = 0; index < x.children.length; index++) {
                            var video = x.children[index];
                            var token = document.getElementsByName('csrf-token')[0].content;
                            var ajax = new XMLHttpRequest();
                            ajax.open("POST", "/member/channel/course/video/reorder", true);
                            ajax.responseType = 'json';
                            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            ajax.send('_token=' + token + '&section_id=' + section.id.split('_')[1] + '&video_id=' + video.id.split('_')[1] + '&order=' + index);
                            ajax.onreadystatechange = function () {
                                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                                    console.log((this.response));
                                }
                            };
                        }
                    }
                });
            });
        }
    });
});

var container = document.getElementById("section_container")

var sections = new Sortable(container, {
    handle: ".intro",
    onEnd(e, ui) {
        var ids = [];
        ids = Array.prototype.map.call(document.getElementById("section_container").children, function (el) {
            return el;
        });
        ids.forEach((item, index) => {
            var token = document.getElementsByName('csrf-token')[0].content;
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "/member/channel/course/sections/reorder", true);
            ajax.responseType = 'json';
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send('_token=' + token + '&section_id=' + item.id.split('_')[1] + '&order=' + index);
            ajax.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    console.log((this.response));
                }
            };
        });
    }
});


//Modal interactions
var modal = document.getElementById("section_modal"),
    btn = document.getElementById("new_section");
modal.addEventListener("click", function (e) {
    if (['INPUT', 'FORM', 'LABEL', 'TEXTAREA', 'BUTTON'].includes(e.target.tagName.toUpperCase())) return false;
    modal.classList.toggle("d-none");
});
btn.addEventListener("click", function () {
    modal.classList.toggle("d-none");
});