import React from "react";
import UIkit from "uikit";
import Duration from "../../DisplayFormatter/duration";

export default class BaseWorkoutStepComponent extends React.Component {
    constructor(props) {
        super(props);
    }

    openVideo(videoLink) {
        UIkit.modal.dialog(
            '<iframe id="ytplayer" type="text/html" width="640" height="360" frameborder="0" allowFullScreen src="' + videoLink + '?autoplay=1" />'
        );
    }

    getDetailsDisplay(workoutStep) {
        let details = null;
        if (workoutStep.type === 'amrap' || workoutStep.type === 'duration' || workoutStep.type === 'rest') {
            details = <Duration value={workoutStep.estimatedDuration} />;
        } else if(workoutStep.type === 'distance') {
            details = (<span><i className="material-icons">directions_run</i>{workoutStep.distance / 1000}km</span>);
        } else if (workoutStep.type === 'reps') {
            details = (<span><i className="material-icons">fitness_center</i>{workoutStep.repsPlanned} reps</span>);
        }

        return details;
    }

    getCoverDisplay(workoutStep) {
        if (null !== workoutStep.exercise.videoLink) {
            return (
                <div className="uk-inline uk-light">
                    <a onClick={() => this.openVideo(workoutStep.exercise.videoLink)} title="Voir la vidéo">
                        <img src={workoutStep.exercise.cover} alt="" className="shf-margin-x-small" />
                        <div className="uk-position-center">
                            <i className="material-icons shf-icon-x-large">play_circle_outline</i>
                        </div>
                    </a>
                </div>
            )
        }

        return (<img src={workoutStep.exercise.cover} alt="" className="shf-margin-x-small" />);
    }
}