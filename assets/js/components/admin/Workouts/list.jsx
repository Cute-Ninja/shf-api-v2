import React from "react";
import Client from '../../common/Api/Client/index';
import FormSelectComponent from "../../common/Form/select";
import FormInputComponent from "../../common/Form/input";
import FormComponent from "../../common/Form/_form";
import Difficulty from "../../common/DisplayFormatter/difficulty";
import Duration from "../../common/DisplayFormatter/duration";

export default class Workouts extends FormComponent {
    constructor(props) {
        super(props);

        this.state = {
            error: null,
            isLoaded: false,
            formData : [],
            workouts: [],
            workoutsCount: 0
        };
    }

    componentDidMount() {
        this.setState({formData: this.getInitializedForm({name: null, difficulty: null})});

        this.handleSubmit();
    }

    handleSubmit(event) {
        if(undefined !== event) {
            event.preventDefault();
        }

        Client.getMany(
            "front/api/reference/workouts",
            this.state.formData
        ).then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    workouts: result.data,
                    workoutsCount: result.count
                });
            }
        );
    }

    render() {
        const {error, isLoaded, formData, workouts, workoutsCount} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading ...</div>;
        }

        return (
            <div>
                <form id="searchForm" className="uk-card uk-card-default uk-form-stacked" onSubmit={this.handleSubmit.bind(this)}>
                    <div className="uk-card-header">
                        Workouts
                    </div>

                    <div className="uk-card-body">
                        <FormInputComponent type="text" name="name" label="Name" value={formData.name}
                                            placeholder="Partial name allowed"
                                            onUpdate={this.handleInputChange.bind(this)} />
                        <FormSelectComponent type="text" name="source" label="Source" value={formData.source}
                                             onUpdate={this.handleInputChange.bind(this)} nullable={true}
                                             options={[{label: 'SHF', value: 'shf'}, {label: 'Community', value: 'community'}]} />
                    </div>

                    <div className="uk-card-footer uk-text-center">
                        <button className="uk-button uk-button-primary" type="submit">Search</button>
                    </div>
                </form>

                <div className="uk-card uk-card-default uk-margin-top">
                    <div className="uk-card-header">
                        <div className="uk-grid" uk-grid="true">
                            <div className="uk-width-expand">
                                {workoutsCount} workout(s) found
                            </div>

                            <div className="uk-width-5-6 uk-text-right">
                                <a href={"workouts/add"} className="uk-button uk-button-primary">
                                    <i className="material-icons">add</i>
                                    <span>NEW</span>
                                </a>
                            </div>
                        </div>
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
                                    <td>
                                        <a href={"workouts/" + workout.id}>
                                            <i className="material-icons">visibility</i>
                                        </a>
                                    </td>
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