import React from 'react';
import UIkit from 'uikit';
import Client from "../../common/Api/Client";
import DurationFormatter from "../../common/DisplayFormatter/duration";

export default class WorkoutStep extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            workoutStep: this.props.workoutStep
        };

        this.markWorkoutStepAs = this.markWorkoutStepAs.bind(this);
        this.openVideo = this.openVideo.bind(this);
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

    openVideo(videoLink) {
        UIkit.modal.dialog(
            '<iframe id="ytplayer" type="text/html" width="640" height="360" frameborder="0" allowFullScreen src="' + videoLink + '?autoplay=1" />'
        );
    }

    render() {
        const {workoutStep} = this.state;

        let details = null;
        if (workoutStep.type === 'amrap' || workoutStep.type === 'duration' || workoutStep.type === 'rest') {
            details = (<span><i className="material-icons">timer</i>{DurationFormatter.formatAsString(workoutStep.estimatedDuration)}</span>);
        } else if(workoutStep.type === 'distance') {
            details = (<span><i className="material-icons">directions_run</i>{workoutStep.distance / 1000}km</span>);
        } else if (workoutStep.type === 'reps') {
            details = (<span><i className="material-icons">fitness_center</i>{workoutStep.repsPlanned} reps</span>);
        }

        let action = null;
        if (workoutStep.workout.type === 'personal') {
            if (workoutStep.status === 'done') {
                action = (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'undo-complete')}
                             title="Re-open exercise" className="workout-step-action-undo">
                    <i className="material-icons">remove_circle_outline</i></a>);
            } else {
                action = (<a onClick={() => this.markWorkoutStepAs(workoutStep.id, 'complete')}
                             title="Mark exercise as done" className="workout-step-action-complete">
                    <i className="material-icons">check_circle_outline</i></a>);
            }
        }

        let cover = null;
        if (null !== workoutStep.exercise.videoLink) {
            cover = (
                <div className="uk-inline uk-light">
                    <a onClick={() => this.openVideo(workoutStep.exercise.videoLink)} title="Voir la vidéo">
                        <img src={workoutStep.exercise.cover} alt="" className="shf-margin-x-small" />
                        <div className="uk-position-center">
                            <i className="material-icons shf-icon-x-large">play_circle_outline</i>
                        </div>
                    </a>
                </div>
            )
        } else {
            cover = (<img src={workoutStep.exercise.cover} alt="" className="shf-margin-x-small" />);
        }

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