import React from 'react';

export default class FormComponent extends React.Component {
    constructor(props) {
        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);
        this.resolveErrors = this.resolveErrors.bind(this);
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
            errors: errors,
            data: data
        };
    }
}