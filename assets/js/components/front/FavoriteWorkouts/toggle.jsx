import React from 'react';
import Client from '../../common/Api/Client/index';
import UIkit from "uikit";

export default class ToggleFavoriteWorkout extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            workout: props.workout
        };

        this.addToFavorite = this.addToFavorite.bind(this);
        this.removeFromFavorite = this.removeFromFavorite.bind(this);
    }

    addToFavorite(workoutId) {
        Client.post(
            "front/api/favorite-workouts",
            {workout: workoutId}
        )
            .then(result => {
                this.state.workout.favoriteId = result.id;
                this.setState({
                    isLoaded: true,
                    workout: this.state.workout
                });

                UIkit.notification('Workout successfully added !', 'success');

            })
            .catch(error => {
                UIkit.notification('An error has occurred ! (Code: ' + error + ')', 'danger');
            });
    }

    removeFromFavorite(workoutName, favoriteId) {
        UIkit.modal.confirm('Are you sure you want to remove ' + workoutName.toUpperCase() + ' from your favorite workouts ?')
            .then(() => {
                Client.deleteOne(
                    "front/api/favorite-workouts",
                    favoriteId
                )
                    .then((result) => {
                        this.state.workout.favoriteId = null;
                        this.setState({
                            isLoaded: true,
                            workout: this.state.workout
                        });

                        UIkit.notification(workoutName.toUpperCase() + ' was successfully removed!', 'success');
                    });
            });
    }

    render() {
        const {error, workout} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        }

        return (
            <div>
                {workout.favoriteId ? (
                    <i onClick={() => this.removeFromFavorite(workout.name, workout.favoriteId)}
                       className="shf-padding-left-small material-icons"
                       title="Remove from favorite">favorite_border</i>
                ) : (
                    <i onClick={() => this.addToFavorite(workout.id)}
                       className="shf-padding-left-small material-icons"
                       title="Add to favorite">favorite</i>
                )
                }
            </div>
        )
    }
}