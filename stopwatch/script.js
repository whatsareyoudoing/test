$(document).ready(function () {
    var timer;
    var isRunning = false;
    var startTime;
    var elapsedTime = 0;
    var flagCount = 1;

    function formatTime(milliseconds) {
        var date = new Date(milliseconds);
        var minutes = date.getUTCMinutes();
        var seconds = date.getUTCSeconds();
        var milliseconds = date.getUTCMilliseconds();

        return (
            (minutes < 10 ? '0' : '') + minutes +
            ':' +
            (seconds < 10 ? '0' : '') + seconds +
            ':' +
            (milliseconds < 10 ? '00' : milliseconds < 100 ? '0' : '') + milliseconds
        );
    }

    function updateDisplay() {
        $('.time').text(formatTime(elapsedTime));
    }

    function addFlag() {
        var flagTime = formatTime(elapsedTime);
        $('.flags').append('<li>Flag ' + flagCount + ': ' + flagTime + '</li>');
        flagCount++;
    }

    function resetStopwatch() {
        clearInterval(timer);
        isRunning = false;
        elapsedTime = 0;
        updateDisplay();
        $('.flags').empty();
        flagCount = 1;
    }

    $('.start').click(function () {
        if (!isRunning) {
            isRunning = true;
            startTime = new Date().getTime() - elapsedTime;
            timer = setInterval(function () {
                elapsedTime = new Date().getTime() - startTime;
                updateDisplay();
            }, 10);
        }
    });

    $('.stop').click(function () {
        if (isRunning) {
            isRunning = false;
            clearInterval(timer);
        }
    });

    $('.flag').click(function () {
        if (isRunning) {
            addFlag();
        }
    });

    $('.reset').click(function () {
        resetStopwatch();
    });
});
