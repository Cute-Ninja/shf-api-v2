import React from "react";
import Client from '../../common/Api/Client/index';
import FormSelectComponent from "../../common/Form/select";
import FormInputComponent from "../../common/Form/input";
import FormComponent from "../../common/Form/form";
import UIkit from "uikit";

export default class Workouts extends FormComponent {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            workouts: [],
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

    componentDidMount() {
        this.handleSubmit();
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
                <form id="workout-search-form" className="uk-card uk-card-default" method="GET" onSubmit={this.handleSubmit}>
                    <div className="uk-card-header">
                        Workouts
                    </div>

                    <div className="uk-card-body">
                        <div className="uk-grid uk-child-width-1-3" uk-grid="true">
                            <FormInputComponent type={'text'} name={'name'}  placeholder="Name of the Workout"
                                                data={this.state.data} errors={this.state.errors.source} />

                            <FormSelectComponent name={'source'} data={this.state.data} errors={this.state.errors.source}
                                                 options={[{label: 'All', value: ''}, {label: 'SHF', value: 'shf'}, {label: 'Community', value: 'community'}]} />
                        </div>
                    </div>

                    <div className="uk-card-footer">
                        <button className="uk-button uk-button-primary shf-margin-small" type="submit">Search</button>
                        <button className="uk-button uk-button-default shf-margin-small" onClick={this.resetForm}>Reset</button>
                    </div>
                </form>

                <div className="uk-card">
                    <div className="uk-card-body">
                        {workouts.map(workout => (
                            <div key={workout.id}>
                                {workout.name}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }
}