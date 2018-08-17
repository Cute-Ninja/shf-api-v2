import React from 'react';
import UIkit from "uikit";
import Client from '../../common/Api/Client/index';

export default class Workouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            workouts: null
        };

        this.addToFavorite = this.addToFavorite.bind(this);
        this.removeFromFavorite = this.removeFromFavorite.bind(this);
    }

    addToFavorite(workoutId, index) {
        Client.post(
                "favorite-workouts",
                {workout: workoutId}
            )
            .then(result => {
                this.updateIsFavoriteField(index, result.id);
                UIkit.notification('Workout successfully added !', 'success');

            })
            .catch(error => {
                UIkit.notification('An error has occurred ! (Code: ' + error + ')', 'danger');
            });
    }

    removeFromFavorite(workoutName, favoriteId, index) {
        UIkit.modal.confirm('Are you sure you want to remove ' + workoutName.toUpperCase() + ' from your favorite workouts ?')
            .then(() => {
                Client.deleteOne(
                    "favorite-workouts",
                    favoriteId
                )
                .then((result) => {
                    this.updateIsFavoriteField(index, null);
                    UIkit.notification(workoutName.toUpperCase() + ' was successfully removed!', 'success');
                });
            });
    }

    updateIsFavoriteField(index, favoriteId) {
        let workouts = this.state.workouts;
        workouts[index].favoriteId = favoriteId;

        this.setState({
            workouts: workouts
        });
    }

    componentDidMount() {
        Client.getMany(
                "workouts",
                {groups : []}
            )
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        workouts: result
                    });
                }
            )
            .catch((errorCode) => {
                UIkit.notification('An error has occurred ! (Code: ' + errorCode + ')', 'danger');
            });
    }

    render() {
        const {error, isLoaded, workouts} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                {workouts.map((workout, index) => (
                    <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                        <div className="uk-card-header shf-remove-border-bottom">
                            <div className="uk-grid" uk-grid>
                                <div className="uk-width-expand">
                                    <h3 uk-toggle={"target: #workout-" + workout.id + "; animation: uk-animation-fade"}
                                        className="uk-text-uppercase shf-clickable-neutral">{workout.name}</h3>
                                </div>
                                <div className="uk-text-right uk-padding-remove-left shf-clickable">
                                    <i uk-toggle={"target: #workout-" + workout.id + "; animation: uk-animation-fade"}
                                        className="material-icons">keyboard_arrow_down</i>

                                    {workout.favoriteId ? (
                                            <i onClick={() => this.removeFromFavorite(workout.name, workout.favoriteId, index)}
                                                className="shf-padding-left-small material-icons"
                                                title="Remove from favorite">favorite_border</i>
                                        ) : (
                                            <i onClick={() => this.addToFavorite(workout.id, index)}
                                                className="shf-padding-left-small material-icons"
                                                title="Add to favorite">favorite</i>
                                        )
                                    }
                                </div>
                            </div>
                        </div>
                        <div className="uk-card-footer">
                            <div className="uk-child-width-expand@s" uk-grid="true">
                                <div>
                                    Difficulty: {workout.difficulty}
                                </div>
                                <div>
                                    <i className="material-icons">timer</i>
                                    {workout.duration / 60}min
                                </div>
                                <div>
                                    <i className="material-icons">whatshot</i>
                                    {workout.calories}
                                </div>
                                <div>
                                    Experience: {workout.experience}
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        );
    }
}