import React from 'react';
import Client from '../../common/Api/Client/index';

export default class Workout extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            workout: null
        };
    }

    componentDidMount() {
        Client.getOne(
            "workouts",
            this.props.workoutId,
            {groups: ['steps']}
        )
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        workout: result
                    });
                }
            );
    }

    render() {
        const {error, isLoaded, workout} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                <div className="uk-card-header shf-remove-border-bottom">
                    <div className="uk-grid" uk-grid>
                        <div className="uk-width-expand">
                            <h3 className="uk-text-uppercase shf-clickable-neutral">{workout.name}</h3>
                        </div>
                    </div>
                </div>
                <div className="uk-card-body">
                    {workout.workoutSteps.map((workoutStep, index) => (
                        <div>
                            {workoutStep.exercise.name} {workoutStep.position}
                        </div>
                    ))}
                </div>
                <div className="uk-card-footer">

                </div>
            </div>
        );
    }
}