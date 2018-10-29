import Client from "../../common/Api/Client/index";
import DateUtils from "../../common/Utils/DateUtils";
import React from 'react';
import ReactMoment from 'react-moment';
import moment from 'moment'
import 'moment/locale/fr';

export default class UserWorkouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            daysOfTheMonth: [],
            currentDate: null
        };

        this.getPreviousMonth = this.getPreviousMonth.bind(this);
        this.getNextMonth     = this.getNextMonth.bind(this);
    }

    componentDidMount() {
        this.getScheduledWorkoutPerMonth(new Date());
    }

    getPreviousMonth() {
        this.getScheduledWorkoutPerMonth(moment(this.state.currentDate).subtract(1, 'month').toDate());
    }

    getNextMonth() {
        this.getScheduledWorkoutPerMonth(moment(this.state.currentDate).add(1, 'month').toDate());

    }

    getScheduledWorkoutPerMonth(date) {
        let days = DateUtils.getDaysInMonth(date.getMonth(), date.getFullYear());
        Client.getMany(
            "front/api/personal/workouts",
            {
                type: 'personal',
                scheduledStart: moment(days[0]).format('YYYY-MM-DD'),
                scheduledEnd: moment(days[days.length - 1]).format('YYYY-MM-DD')
            }
        )
            .then(
                (results) => {
                    let daysOfTheMonth = [];
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

                        daysOfTheMonth.push({
                            date: day,
                            workout: workout
                        })
                    });

                    this.setState({
                        isLoaded: true,
                        daysOfTheMonth: daysOfTheMonth,
                        currentDate: date
                    });
                }
            );
    }

    render() {
        const {isLoaded, daysOfTheMonth, currentDate} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                <div className="uk-grid-small uk-flex-middle uk-grid" uk-grid="true">
                    <div className="uk-width-auto">
                        <a href="#" onClick={() => this.getPreviousMonth()} title="Display previous month planning"
                           uk-icon="icon: arrow-left; ratio: 1.2">
                        </a>
                    </div>
                    <div className="uk-width-expand">
                        <h4 className="shf-ucfirst uk-text-center">{moment(currentDate).format('MMMM')}</h4>
                    </div>
                    <div className="uk-width-auto">
                        <a href="#" onClick={() => this.getNextMonth()} title="Display next month planning"
                           uk-icon="icon: arrow-right; ratio: 1.2">
                        </a>
                    </div>
                </div>
                <div>
                    {daysOfTheMonth.map((dayOfTheMonth, index) => (
                        <div key={index} className="day-of-the-month">
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