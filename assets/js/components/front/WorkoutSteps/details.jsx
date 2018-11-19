import React from 'react';
import Client from "../../common/Api/Client";
import BaseWorkoutStepComponent from "../../common/Domain/WorkoutSteps/_details";

export default class WorkoutStep extends BaseWorkoutStepComponent {
    constructor(props) {
        super(props);
        this.state = {
            workoutStep: this.props.workoutStep
        };

        this.markWorkoutStepAs = this.markWorkoutStepAs.bind(this);
    }

    getActionDisplay(workoutStep) {
        if (workoutStep.workout.type === 'personal') {
            if (workoutStep.status === 'done') {
                return (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'undo-complete')}
                           title="Re-open exercise" className="workout-step-action-undo">
                    <i className="material-icons">remove_circle_outline</i></a>);
            } else {
                return (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'complete')}
                           title="Mark exercise as done" className="workout-step-action-complete">
                    <i className="material-icons">check_circle_outline</i></a>);
            }
        }
    }

    markWorkoutStepAs(workoutStepId, action) {
        Client.patch(
            "front/api/workouts/" + this.props.workoutId + "/steps",
            action,
            {id: workoutStepId}
        ).then((result) => {
            this.setState({workoutStep: result});
        });
    }

    render() {
        const {workoutStep} = this.state;

        let cover   = this.getCoverDisplay(workoutStep);
        let details = this.getDetailsDisplay(workoutStep);
        let action  = this.getActionDisplay(workoutStep);

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

                <div className="uk-width-auto@m">
                    {action}
                </div>
            </div>
        )
    }
}