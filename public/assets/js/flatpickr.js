// npm package: flatpickr
// github link: https://github.com/flatpickr/flatpickr

$(function() {
  'use strict';

  // date picker 
  if($('#flatpickr-date').length) {
    flatpickr("#flatpickr-date", {
      wrap: true,
      dateFormat: "Y-m-d",
    });
  }


  // time picker
  if($('#flatpickr-time').length) {
    flatpickr("#flatpickr-time", {
      wrap: true,
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true
    });
  }

    // Date Time
    if ($('#flatpickr-date-time').length) {
        flatpickr("#flatpickr-date-time", {
            static: true,
            wrap: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    }
    if ($('#flatpickr-dtc').length) {
        flatpickr("#flatpickr-dtc", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    }
});