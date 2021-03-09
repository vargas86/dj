import flatpickr from "flatpickr";
var defaultDate = (new Date);
if (typeof oldDate !== 'undefined') {
    defaultDate = oldDate;
}
flatpickr("#schedule", {
    enableTime: true,
    dateFormat: 'm/d/Y H:i',
    minDate: (new Date),
    defaultDate: oldDate,
    time_24hr: true,
});