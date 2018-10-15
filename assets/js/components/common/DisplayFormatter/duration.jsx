
function formatAsArray(durationInSeconds) {
    let hours = 0;
    let minutes = 0;
    let seconds = durationInSeconds;

    if (durationInSeconds > 60) {
        minutes = Math.floor(durationInSeconds / 60);
        seconds = durationInSeconds - (minutes * 60);
    }

    if (minutes > 60) {
        hours = Math.floor(minutes / 60);
        minutes = minutes - (hours * 60);
    }

    return [hours, minutes, seconds];
}

function formatAsString(durationInSeconds) {
    let [hours, minutes, seconds] = formatAsArray(durationInSeconds);

    let formatted = '';
    if (hours > 0) {
        formatted = hours + 'h ';
    }

    if (minutes > 0) {
        formatted += minutes + 'min ';
    }

    if (seconds > 0) {
        formatted += seconds + 'sec ';
    }

    return formatted;
}

const Duration = {
    formatAsString
};

export default Duration;