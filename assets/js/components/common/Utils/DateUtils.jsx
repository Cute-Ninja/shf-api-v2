function getDaysInWeek(curr) {
    let month = curr.getMonth();
    let year  = curr.getFullYear();

    let days = [];
    let first = (curr.getDate() - curr.getDay()) +1;//to set first day on monday, not on sunday, first+1 :
    let firstday = new Date(year, month, first);

    days.push(firstday);
    for (let i = 1; i < 7; i++) {
        let next = new Date(year, month, (first + i));
        days.push(next);
    }

    return days;
}

function getDaysInMonth(month, year) {
    let date = new Date(year, month, 1);
    let days = [];

    while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
    }

    return days;
}

function formatDurationAsArray(durationInSeconds) {
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

const DateUtils = {
    getDaysInMonth, getDaysInWeek, formatDurationAsArray
};

export default DateUtils;