import React from "react";
import Client from '../../common/Api/Client/index';
import FormSelectComponent from "../../common/Form/select";
import FormInputComponent from "../../common/Form/input";
import FormComponent from "../../common/Form/form";
import UIkit from "uikit";
import Difficulty from "../../common/DisplayFormatter/difficulty";
import Duration from "../../common/DisplayFormatter/duration";

export default class Workouts extends FormComponent {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            workouts: [],
            workoutsCount: 0
        };

        this.initializeState(['name', 'source']);
    }

    handleSubmit(event) {
        if(undefined !== event) {
            event.preventDefault();
        }

        Client.getMany(
            "front/api/reference/workouts",
            this.state.data
        ).then(
            (result) => {
                console.log(result);
                this.setState({
                    isLoaded: true,
                    workouts: result.data,
                    workoutsCount: result.count
                });
            }
        )
        .catch((errorCode) => {
            UIkit.notification('An error has occurred ! (Code: ' + errorCode + ')', 'danger');
        });
    }

    componentDidMount() {
        this.handleSubmit();
    }

    render() {
        const {error, isLoaded, workouts, workoutsCount} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                <form id="workout-search-form" className="uk-card uk-card-default uk-form-stacked"
                      method="GET" onSubmit={this.handleSubmit}>
                    <div className="uk-card-header">
                        Workouts
                    </div>

                    <div className="uk-card-body">
                        <div className="uk-grid" uk-grid="true">
                            <div className="uk-width-1-3">
                                <FormInputComponent type={'text'} name={'name'} label="Workout" placeholder="Partial name allowed"
                                                data={this.state.data} errors={this.state.errors.source} />
                            </div>

                            <div className="uk-width-1-3">
                                <FormSelectComponent name={'source'} label="Source"
                                                 data={this.state.data} errors={this.state.errors.source}
                                                 options={[{label: 'All', value: ''}, {label: 'SHF', value: 'shf'}, {label: 'Community', value: 'community'}]} />
                            </div>
                        </div>
                    </div>

                    <div className="uk-card-footer uk-text-center">
                        <button className="uk-button uk-button-primary" type="submit">Search</button>
                        &nbsp;
                        <button className="uk-button uk-button-default" onClick={this.resetForm}>Reset</button>
                    </div>
                </form>

                <div className="uk-card uk-card-default uk-margin-top">
                    <div className="uk-card-header">
                        {workoutsCount} workout(s) found
                    </div>
                    <div className="uk-card-body">
                        <table className="uk-table uk-table-divider uk-table-hover uk-table-middle uk-margin-remove-top">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Difficulty</th>
                                <th>Duration</th>
                                <th>XP</th>
                                <th>Calories</th>
                                <th>Source</th>
                            </tr>
                            </thead>
                            <tbody>
                                {workouts.map(workout => (
                                <tr key={workout.id}>
                                    <td>{workout.name}</td>
                                    <td><Difficulty value={workout.difficulty} /></td>
                                    <td><Duration value={workout.estimatedDuration} /></td>
                                    <td>{workout.experience}xp</td>
                                    <td>{workout.calories}kcal</td>
                                    <td>{workout.source}</td>
                                </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        );
    }
}