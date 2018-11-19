import React from "react";
import SaveWorkout from "./_save";
import Client from "../../common/Api/Client";

export default class UpdateWorkout extends SaveWorkout {
    handleSubmit(event) {
        event.preventDefault();

        Client.put(
            "admin/api/workouts/" + this.props.workoutId,
            this.state.formData
        ).then((result) => {
            window.location = result.id;
        });
    }

    toggleEditMode() {
        this.setState({readOnly: !this.state.readOnly});
    }


    componentDidMount() {
        Client.getOne(
            "admin/api/workouts",
            this.props.workoutId
        ).then(result => {
            this.setState({
                isLoaded: true,
                formData: this.getInitializedForm({
                    name: result.name,
                    difficulty: result.difficulty,
                })
            });
        });
    }

    render() {
        return super.render();
    }
}