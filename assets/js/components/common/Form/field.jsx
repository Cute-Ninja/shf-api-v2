import React from 'react';

export default class FormFieldComponent extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            data: this.props.data
        };

        this.handleInputChange = this.handleInputChange.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;

        this.state.data[name] = value;

        this.forceUpdate();

        console.log(this.state);
    }
}