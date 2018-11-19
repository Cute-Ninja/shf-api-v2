import React from 'react';
import UIkit from "uikit";
import Client from '../../common/Api/Client/index';
import Difficulty from "../../common/DisplayFormatter/difficulty";
import Duration from "../../common/DisplayFormatter/duration";

export default class Workouts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            workouts: null
        };

        this.loadWorkouts = this.loadWorkouts.bind(this)
    }
    
    loadWorkouts(source) {
        Client.getMany(
            "front/api/reference/workouts",
            {source : source}
        ).then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    workouts: result.data
                });
            }
        )
        .catch((errorCode) => {
            UIkit.notification('An error has occurred ! (Code: ' + errorCode + ')', 'danger');
        });
    }

    componentDidMount() {
        this.loadWorkouts('shf');
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
                <div className="uk-clearfix">
                    <div className="uk-inline uk-margin-bottom uk-float-right">
                        <button type="button" className="uk-button uk-button-primary">
                            Source&nbsp;<span uk-icon="icon: triangle-down"></span></button>
                        <div uk-dropdown="mode: click">
                            <ul className="uk-nav uk-dropdown-nav">
                                <li onClick={() => this.loadWorkouts('shf')}>
                                    <a href="#">SHF</a></li>
                                <li onClick={() => this.loadWorkouts('community')}>
                                    <a href="#">Community</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {workouts.map(workout => (
                    <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                        <div className="uk-card-header shf-remove-border-bottom">
                            <div className="uk-grid" uk-grid="true">
                                <h3 className="uk-text-uppercase shf-clickable-neutral">
                                    <a href={"/front/workouts/" + workout.id}>{workout.name}</a></h3>
                            </div>
                        </div>
                        <div className="uk-card-footer">
                            <div className="uk-child-width-expand@s" uk-grid="true">
                                <div>
                                    <Difficulty value={workout.difficulty} />
                                </div>
                                <div>
                                    <Duration value={workout.estimatedDuration} />
                                </div>
                                <div>
                                    <i className="material-icons">whatshot</i>
                                    {workout.calories}kcal
                                </div>
                                <div>
                                    {workout.experience}xp
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        );
    }
}