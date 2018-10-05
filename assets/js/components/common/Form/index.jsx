import React from 'react';

export default class FormComponent extends React.Component {
    constructor(props) {
        super(props);

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;

        this.state.data[name] = value;

        this.forceUpdate();
    }

    initializeState(formFields) {
        let errors = {};
        let data   = {};
        formFields.map(formField => {
            data[formField]   = '';
            errors[formField] = '';
        });

        this.state = {
            isLoaded: false,
            errors: errors,
            data: data
        };
    }
}