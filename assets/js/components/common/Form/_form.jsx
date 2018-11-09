import React from 'react';

export default class FormComponent extends React.Component {
    constructor(props) {
        super(props);

        this.handleSubmit  = this.handleSubmit.bind(this);
        this.resolveErrors = this.resolveErrors.bind(this);
    }

    handleSubmit(event) {
        throw new TypeError('Method "handleSubmit" should be override in the specific form component');
    }

    getInitializedForm(formFields) {
        let formData = [];
        Object.keys(formFields).map(fieldName => {
            let fieldValue = formFields[fieldName];
            formData[fieldName] = null === fieldValue ? "" : fieldValue;
        });

        return formData;
    }

    resolveErrors(errors) {
        Object.assign(this.state.errors, errors);

        this.forceUpdate();
    }

    handleInputChange(event) {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;

        let formData = this.state.formData;
        formData[name] = value;

        this.setState({formData: formData});
    }
}