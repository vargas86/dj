import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('my-calendar');
    events = JSON.parse(events);
    events.forEach(element => {
        element.url = '/live/'+element.slug;
    });
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin],
            events: events,
            eventClick(i) {
                // console.log("open event " + i.event.id);
            }
        });
    }
    calendar.render();
});