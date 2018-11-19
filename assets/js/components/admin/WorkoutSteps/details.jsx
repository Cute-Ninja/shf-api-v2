import React from "react";
import BaseWorkoutStepComponent from "../../common/Domain/WorkoutSteps/_details";

export default class WorkoutStep extends BaseWorkoutStepComponent {
    constructor(props) {
        super(props);
        this.state = {
            workoutStep: this.props.workoutStep
        };
    }

    render() {
        const {workoutStep} = this.state;

        let cover   = this.getCoverDisplay(workoutStep);
        let details = this.getDetailsDisplay(workoutStep);

        return (
            <div key={workoutStep.id} uk-grid="true"
                 className="uk-grid uk-card uk-card-default uk-grid-collapse uk-margin">
                <div className="uk-width-auto@m">
                    {cover}
                </div>

                <div className="uk-width-expand@m">
                    <div className="uk-card-body">
                        <h3 className="uk-card-title">{workoutStep.position}. {workoutStep.exercise.name}</h3>
                        <p>{details}</p>
                    </div>
                </div>
            </div>
        );
    }
}