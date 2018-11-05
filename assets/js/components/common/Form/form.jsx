import React from 'react';

export default class FormComponent extends React.Component {
    constructor(props) {
        super(props);

        this.handleSubmit  = this.handleSubmit.bind(this);
        this.resolveErrors = this.resolveErrors.bind(this);
        this.resetForm     = this.resetForm.bind(this);
    }

    handleSubmit(event) {
        throw new TypeError('Method "handleSubmit" should be override in the specific form component');
    }

    resolveErrors(errors) {
        Object.assign(this.state.errors, errors);

        this.forceUpdate();
    }

    resetForm(event) {
        event.preventDefault();
        this.initializeState(this.state.formFields);
    }

    initializeState(formFields) {
        let errors = {};
        let data   = {};
        formFields.map(formField => {
            let field = document.getElementById(formField);
            if (null !== field) {
                field.value = "";
            }

            data[formField]   = '';
            errors[formField] = [];
        });

        this.state = {
            isLoaded: false,
            successful: false,
            errors: errors,
            data: data,
            formFields: formFields
        };
    }
}