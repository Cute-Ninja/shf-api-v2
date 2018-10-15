import React from 'react';
import Client from "../../common/Api/Client/index";
import Moment from 'react-moment';
import 'moment/locale/fr';

export default class UserWorkouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            workouts: null
        };
    }

    componentDidMount() {
        Client.getMany(
            "front/api/personal/workouts",
            {status: 'scheduled'}
        )
        .then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    workouts: result
                });
            }
        );
    }

    render() {
        const {isLoaded, workouts} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        if (0 === workouts.length) {
            return (
                <div>
                    No workout planned yet ? <a href="/front/workouts" title="">Let's find one !</a>
                </div>
            );
        }

        return (
            <div>
                {workouts.map((workout) => (
                    <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                        <div className="uk-clearfix">
                            <div className="uk-float-left">
                                <a href={"/front/workouts/" + workout.id}>{workout.name}</a>
                            </div>
                            <div className="uk-float-right">
                                <Moment format="LLLL">{workout.scheduledDate}</Moment>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        );
    }
}