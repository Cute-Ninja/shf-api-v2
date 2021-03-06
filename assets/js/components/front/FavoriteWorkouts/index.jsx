import React from 'react';
import UIkit from 'uikit';
import Client from '../../common/Api/Client/index';
import Difficulty from "../../common/DisplayFormatter/difficulty";
import Duration from "../../common/DisplayFormatter/duration";

export default class FavoriteWorkouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            favorites: null
        };

        this.removeFromFavorite = this.removeFromFavorite.bind(this);
    }

    componentDidMount() {
        Client.getMany("front/api/favorite-workouts")
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        favorites: result.data
                    });
                }
            );
    }

    removeFromFavorite(favorite, index) {
        UIkit.modal.confirm('Are you sure you want to remove ' + favorite.workout.name.toUpperCase() + ' from your favorite workouts ?')
            .then(() => {
                Client.deleteOne(
                    "front/api/favorite-workouts",
                    favorite.id
                )
                .then((result) => {
                    let favorites = this.state.favorites;
                    favorites.splice(index, 1);
                    this.setState({
                       favorites: favorites
                    });
                    UIkit.notification(favorite.name.toUpperCase() + ' was successfully removed!', 'success');
                });
            });
    }

    render() {
        const {isLoaded, favorites} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        if (favorites.length === 0) {
            return (
                <div>
                    No workout favorites yet ? <a href="/front/workouts" title="">Let's find one !</a>
                </div>
            )
        }

        return (
            <div>
                <table className="uk-table  uk-table-striped">
                    <thead>
                        <tr>
                            <td className="uk-table-expand">Name</td>
                            <td>Difficulty</td>
                            <td>Duration</td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        {favorites.map((favorite, index) => (
                            <tr ref={'favorite-workout-' + favorite.id} key={favorite.id}>
                                <td>
                                    <a href={"/front/workouts/" + favorite.workout.id}>{favorite.workout.name}</a>
                                </td>
                                <td><Difficulty value={favorite.workout.difficulty} /></td>
                                <td><Duration value={favorite.workout.estimatedDuration} /></td>
                                <td>
                                    <i onClick={() => {this.removeFromFavorite(favorite, index)}}
                                       title={"Remove " + (favorite.workout.name).toUpperCase() + " from your favorite workout"}
                                        className="material-icons shf-clickable">favorite_border</i>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                <div className="uk-text-center">
                    <a href="/front/workouts" title="">Find more workouts</a>
                </div>
            </div>
        );
    }
}