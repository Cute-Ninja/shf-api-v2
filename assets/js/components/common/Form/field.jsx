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
    }

    render() {
        return (
            <div className="uk-margin">
                <input id={this.props.name} name={this.props.name} value={this.state.data[this.state.name]}
                       type={this.props.type} placeholder={this.props.placeholder}
                       onChange={this.handleInputChange}
                       className="uk-input" />
                <div id={this.props.name + '-error'}>
                    <ul>
                        {this.props.errors.map((error, index) => (
                            <li key={this.props.name + "-error-" + index}>{error}</li>
                        ))}
                    </ul>
                </div>
            </div>
        );
    }
}