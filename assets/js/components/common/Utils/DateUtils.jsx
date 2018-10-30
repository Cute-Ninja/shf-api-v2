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

const DateUtils = {
    getDaysInMonth, getDaysInWeek
};

export default DateUtils;