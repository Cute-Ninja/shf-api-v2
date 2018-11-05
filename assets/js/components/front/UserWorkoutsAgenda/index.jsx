import Client from "../../common/Api/Client/index";
import DateUtils from "../../common/Utils/DateUtils";
import React from 'react';
import ReactMoment from 'react-moment';
import moment from 'moment'
import 'moment/locale/fr';

export default class UserWorkoutsAgenda extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            daysOfTheWeek: [],
            currentDate: null
        };

        this.getPreviousWeek = this.getPreviousWeek.bind(this);
        this.getNextWeek     = this.getNextWeek.bind(this);
    }

    componentDidMount() {
        this.getScheduledWorkoutPerMonth(new Date());
    }

    getPreviousWeek() {
        this.getScheduledWorkoutPerMonth(moment(this.state.currentDate).subtract(1, 'week').toDate());
    }

    getNextWeek() {
        this.getScheduledWorkoutPerMonth(moment(this.state.currentDate).add(1, 'week').toDate());

    }

    getScheduledWorkoutPerMonth(date) {
        let days = DateUtils.getDaysInWeek(date);
        Client.getMany(
            "front/api/personal/workouts",
            {
                type: 'personal',
                scheduledStart: moment(days[0]).format('YYYY-MM-DD'),
                scheduledEnd: moment(days[days.length - 1]).format('YYYY-MM-DD')
            }
        ).then(
            (results) => {
                let daysOfTheWeek = [];
                days.map(day => {
                    let workout = null;
                    results.map((result, index) => {
                        let formattedDay      = moment(day).format('YYYY-MM-DD');
                        let formattedSchedule = moment(result.scheduledDate).format('YYYY-MM-DD');
                        if (formattedDay === formattedSchedule) {
                            workout = result;
                            results.splice(index, 1);
                        }
                    });

                    daysOfTheWeek.push({
                        date: day,
                        workout: workout,
                        isCurrent: day.getDate() === (new Date()).getDate()
                    });
                });

                this.setState({
                    isLoaded: true,
                    daysOfTheWeek: daysOfTheWeek,
                    currentDate: date
                });
            }
        );
    }

    render() {
        const {isLoaded, daysOfTheWeek} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                <div className="uk-grid-small uk-flex-middle uk-grid" uk-grid="true">
                    <div className="uk-width-auto">
                        <a href="#" onClick={() => this.getPreviousWeek()} title="Display previous month planning"
                           uk-icon="icon: arrow-left; ratio: 1.2">
                        </a>
                    </div>
                    <div className="uk-width-expand">
                        <h4 className="shf-ucfirst uk-text-center">
                            {moment(daysOfTheWeek[0].date).format('DD MMMM')} - {moment(daysOfTheWeek[daysOfTheWeek.length - 1].date).format(' DD MMMM')}
                        </h4>
                    </div>
                    <div className="uk-width-auto">
                        <a href="#" onClick={() => this.getNextWeek()} title="Display next month planning"
                           uk-icon="icon: arrow-right; ratio: 1.2">
                        </a>
                    </div>
                </div>
                <div>
                    {daysOfTheWeek.map((dayOfTheMonth, index) => (
                        <div key={index} className={"day-of-the-month" + (dayOfTheMonth.isCurrent ? " current-day" : "")}>
                            <div><ReactMoment format="dddd DD">{dayOfTheMonth.date}</ReactMoment></div>
                            <div>
                                {dayOfTheMonth.workout ? (
                                    <a href={"/front/workouts/" + dayOfTheMonth.workout.id} title="See workout details">
                                        {dayOfTheMonth.workout.name}</a>
                                ) : (
                                    <span>&nbsp;</span>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        );
    }
}