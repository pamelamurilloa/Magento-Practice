define([], function () {
    'use strict';

    return function (config, element) {
        var totalSeconds = 0;
        var display = element.querySelector('.counter-display');

        startCounter(display);

        function startCounter(display) {
            setInterval(function () {
                totalSeconds++;

                var minutes = parseInt(totalSeconds / 60, 10);
                var seconds = parseInt(totalSeconds % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

            }, 1000); // every second
        }
    };
});