import React from 'react';
import Client from '../../common/Api/Client/index';
import ToggleFavoriteWorkout from "../FavoriteWorkouts/toggle";

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
            "front/api/workouts",
            this.props.workoutId,
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
                    <div className="uk-grid" uk-grid="true">
                        <div className="uk-width-expand">
                            <h3 className="uk-text-uppercase">{workout.name}</h3>
                        </div>
                        <div className="uk-text-right uk-padding-remove-left shf-clickable">
                            <ToggleFavoriteWorkout workout={workout} />
                        </div>
                    </div>
                </div>
                <div className="uk-card-body">
                    BODY
                </div>
                <div className="uk-card-footer">
                    FOOTER
                </div>
            </div>
        );
    }
}