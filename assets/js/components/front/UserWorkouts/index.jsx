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
            "personal/workouts",
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

        return (
            <div>
                {workouts.map((workout, index) => (
                    <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                        {workout.name}
                        <Moment format="LLLL">
                            {workout.scheduledDate}
                        </Moment>
                    </div>
                ))}
            </div>
        );
    }
}