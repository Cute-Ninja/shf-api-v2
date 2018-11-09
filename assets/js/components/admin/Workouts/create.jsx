import SaveWorkout from "./_save";
import Client from "../../common/Api/Client";

export default class CreateWorkout extends SaveWorkout {
    handleSubmit(event) {
        event.preventDefault();

        Client.post(
            "admin/api/workouts",
            this.state.formData
        ).then((result) => {
            window.location = result.id;
        });
    }

    componentDidMount() {
        this.setState({
            isLoaded: true,
            readOnly: false,
            formData: this.getInitializedForm({name: null, difficulty: 5})
        });
    }

    render() {
        return super.render();
    }
}