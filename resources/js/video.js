import plyr from 'plyr';

const player = new plyr('#player');
player.source = JSON.parse(sources);
player.poster = (poster) ? poster : null;

//Toggling course sections
var headings = document.querySelectorAll(".section-heading");
headings.forEach(h => h.addEventListener("click", () => h.nextSibling.nextSibling.classList.toggle("collapsed")));

//Toggling replies
document.addEventListener('click', function (e) {

    if (e.target && e.target.className === 'toggle-replies') {
        var target = e.target.closest('.comment-container').querySelector(".replies");
        target.classList.toggle("collapsed");
        e.target.innerHTML = target.classList.contains("collapsed")
            ? '<i class="uil uil-angle-down"></i>View replies'
            : '<i class="uil uil-angle-up"></i>Hide replies';
    }
});

var chat_messages = {
    '0.5': [
        {
            'icon': '/images/peoples/a.png',
            'username': '',
            'message': ''
        }
    ]
};

// Windows loaded
(function () {
    'use strict';

    // Page load
    window.addEventListener('load', function () {

        if (typeof (player) != 'undefined') {

            // console.log(chat_messages);

            player.on('timeupdate', event => {
                const instance = event.detail.plyr;
                console.log(instance.currentTime);
            });

        } else {
            console.log('No');
        }

    });
})();

//Read more, read less
var more_btn = document.querySelector(".read-more");
more_btn.addEventListener("click", function (e) {
    var p = e.target.parentNode.querySelector("p");
    p.classList.toggle("expand");
    more_btn.innerHTML = p.classList.contains("expand") ? "Read less ..." : "Read more ...";
});
