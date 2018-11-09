import React from "react";
import FormComponent from "../../common/Form/_form";
import FormInputComponent from "../../common/Form/input";
import FormSelectComponent from "../../common/Form/select";

export default class SaveWorkout extends FormComponent {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            readOnly: true,
            formData: []
        };

        this.toggleEditMode = this.toggleEditMode.bind(this);
    }

    toggleEditMode() {}

    render() {
        const {error, isLoaded, readOnly, formData} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        let cardHeader = null;
        if (null === this.props.workoutId) {
            cardHeader = (<div>New Workout</div>);
        } else {
            cardHeader = (
                <div>
                    {formData.name}
                    <a href="#" onClick={this.toggleEditMode}>
                        <i className="material-icons">{readOnly ? 'mode_edit' : 'close'}</i>
                    </a>
                </div>
            );
        }
        return (
            <div className="uk-card uk-card-default">
                <div className="uk-card-header">
                    {cardHeader}
                </div>

                <form id="saveForm" className="uk-form-stacked" onSubmit={this.handleSubmit.bind(this)}>
                    <div className="uk-card-body">
                        <FormInputComponent type="text" name="name" value={formData.name}
                                            readOnly={readOnly}
                                            onUpdate={this.handleInputChange.bind(this)} />
                        <FormSelectComponent type="text" name="difficulty" value={formData.difficulty}
                                             options={[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}
                                             readOnly={readOnly}
                                             onUpdate={this.handleInputChange.bind(this)} />
                    </div>

                    <div className={"uk-card-footer uk-text-center" +  (readOnly ? " uk-hidden" : "")}>
                        <button type="submit" className="uk-button uk-button-primary">Save</button>
                    </div>
                </form>
            </div>
        );
    }
}