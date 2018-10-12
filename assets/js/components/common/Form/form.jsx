import React from 'react';

export default class FormComponent extends React.Component {
    constructor(props) {
        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);
        this.resolveErrors = this.resolveErrors.bind(this);
    }

    handleSubmit(event) {
        throw new TypeError('Method "handleSubmit" should be override in the specific form component');
    }

    resolveErrors(errors) {
        Object.assign(this.state.errors, errors);

        this.forceUpdate();
    }

    initializeState(formFields) {
        let errors = {};
        let data   = {};
        formFields.map(formField => {
            data[formField]   = '';
            errors[formField] = [];
        });

        this.state = {
            isLoaded: false,
            successful: false,
            errors: errors,
            data: data
        };
    }
}