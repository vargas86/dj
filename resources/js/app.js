//User modal
if (document.getElementById("user_avatar"))
    document.getElementById("user_avatar")
        .addEventListener("click", () => document.getElementById("user_modal").classList.toggle("toggled"));

//Collapsable topics menu
var collapsables = document.querySelectorAll(".sub-topic>i");

collapsables.forEach(c => {
    c.addEventListener("click", () => {
        c.parentNode.classList.toggle("collapsed");
    });
});


//Sidemenu toggle
var burger = document.getElementById("burger");
var layout = document.querySelector(".app-layout");
burger.addEventListener("click", () => layout.classList.add("with-menu"));

layout.addEventListener("click", function (e) { 
    if(e.target.tagName== 'I') return false; 
    this.classList.remove("with-menu");
});

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        events: [
            {
                title: 'Course: Kicking',
                start: '2021-01-10',
                url: "/watch"
            },
            {
                title: 'Course: Kicking',
                start: '2021-01-9',
                url: "/watch"
            },
            {
                title: 'Course: Punching',
                start: '2021-01-19',
                url: "/watch"
            },
        ],
        eventClick(i) {
            // console.log("open event " + i.event.id);
        }
    });

    calendar.render();
});