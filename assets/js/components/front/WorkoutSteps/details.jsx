import React from 'react';
import Client from "../../common/Api/Client";

export default class WorkoutStep extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            workoutStep: this.props.workoutStep
        };

        this.markWorkoutStepAs = this.markWorkoutStepAs.bind(this);
    }

    markWorkoutStepAs(workoutStepId, action) {
        Client.patch(
            "workouts/" + this.props.workoutId + "/steps",
            action,
            {id: workoutStepId}
        ).then((result) => {
            this.setState({workoutStep: result});
        });
    }

    render() {
        const {workoutStep} = this.state;

        let details = null;
        if (workoutStep.type === 'amrap' || workoutStep.type === 'duration' || workoutStep.type === 'rest') {
            details = (<span><i className="material-icons">timer</i>{workoutStep.duration / 60}min</span>);
        } else if(workoutStep.type === 'distance') {
            details = (<span><i className="material-icons">directions_run</i>{workoutStep.distance / 1000}km</span>);
        } else if (workoutStep.type === 'reps') {
            details = (<span><i className="material-icons">fitness_center</i>{workoutStep.numberOfRepetition} reps</span>);
        }

        let action = null;
        if (workoutStep.workout.type === 'personal') {
            if (workoutStep.status === 'done') {
                action = (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'undo')}
                             title="Re-open exercise" className="workout-step-action-undo">
                    <i className="material-icons">remove_circle_outline</i></a>);
            } else {
                action = (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'complete')}
                             title="Mark exercise as done" className="workout-step-action-complete">
                    <i className="material-icons">check_circle_outline</i></a>);
            }
        }

        return (
            <div key={workoutStep.id} className="uk-card uk-card-default uk-margin-bottom">
                <div className="uk-card-body uk-clearfix">
                    <div className="uk-float-left">
                        {workoutStep.position}. {workoutStep.exercise.name}
                        {details}
                    </div>
                    <div className="uk-float-right">
                        {action}
                    </div>
                </div>
            </div>
        );
    }
}