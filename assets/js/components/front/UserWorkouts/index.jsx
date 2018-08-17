import React from 'react';
import Client from "../../common/Api/Client/index";
import Moment from 'react-moment';
import 'moment/locale/fr';

export default class UserWorkouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            userWorkouts: null
        };
    }

    componentDidMount() {
        Client.getMany("user-workouts", {status: 'scheduled'})
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        userWorkouts: result
                    });
                }
            );
    }

    render() {
        const {isLoaded, userWorkouts} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                {userWorkouts.map((userWorkout, index) => (
                    <div>
                        {userWorkout.workout.name}
                        <Moment format="LLLL">
                            {userWorkout.scheduledDate}
                        </Moment>
                    </div>
                ))}
            </div>
        );
    }
}