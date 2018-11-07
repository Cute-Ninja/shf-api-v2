import React from 'react';
import UIkit from "uikit";
import Client from '../../common/Api/Client/index';
import WorkoutStep from "./details";

export default class WorkoutSteps extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            workoutSteps: null
        };
    }

    componentDidMount() {
        Client.getMany(
            "front/api/workouts/" + this.props.workoutId + "/steps",
        )
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        workoutSteps: result.data
                    });
                }
            )
            .catch((errorCode) => {
                UIkit.notification('An error has occurred ! (Code: ' + errorCode + ')', 'danger');
            });
    }

    render() {
        const {error, isLoaded, workoutSteps} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                {workoutSteps.map((workoutStep) => (
                    <div key={workoutStep.id}>
                        <WorkoutStep
                            workoutId={this.props.workoutId}
                            workoutStep={workoutStep} />
                    </div>
                ))}
            </div>
        );
    }
}
