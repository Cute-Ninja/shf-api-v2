import React from "react";
import Client from "../../common/Api/Client";
import WorkoutStep from "./details";

export default class WorkoutSteps extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            steps: [],
            stepsCount: 0
        };
    }

    componentDidMount() {
        Client
            .getMany('admin/api/workouts/' + this.props.workoutId + '/steps')
            .then(result => {
                this.setState({
                    isLoaded: true,
                    steps: result.data,
                    stepsCount: result.count
                })
            })
    }

    render() {
        const {isLoaded, error, steps, stepsCount} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                <div className="uk-margin-top uk-text-right">
                    <button className="uk-button uk-button-primary">
                        <i className="material-icons">add</i>
                        Add workout
                    </button>
                </div>

                <div>
                    <span>{stepsCount}</span>
                    {steps.map((step) => (
                        <div key={step.id}>
                            <WorkoutStep
                                workoutId={this.props.workoutId}
                                workoutStep={step} />
                        </div>
                    ))}
                </div>
            </div>
        );
    }
}