import React from 'react';
import FormFieldComponent from "./field";

export default class FormInputComponent extends FormFieldComponent {
    render() {
        let info = this.props.info === undefined ? '' : this.props.info;

        return (
            <div className="uk-margin shf-form-field">
                <input id={this.props.name} name={this.props.name} value={this.state.data[this.props.name]}
                       type={this.props.type} placeholder={this.props.placeholder}
                       onChange={this.handleInputChange}
                       className="uk-input" />
                <span className="info">{info}</span>
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