import React from 'react';
import FormFieldComponent from "./field";

export default class FormSelectComponent extends FormFieldComponent {
    render() {
        let info = this.props.info === undefined ? '' : this.props.info;

        return (
            <div className="shf-form-field">
                <label className="uk-form-label" htmlFor={this.props.name}>
                    {this.props.label}
                </label>
                <div className="uk-form-controls">
                    <select id={this.props.name} name={this.props.name} value={this.state.data[this.props.name]}
                           placeholder={this.props.placeholder}
                           onChange={this.handleInputChange}
                           className="uk-select">
                        {this.props.options.map((option, index) => (
                            <option key={index} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                    <span className="info">{info}</span>
                    <div id={this.props.name + '-error'}>
                        <ul>
                            {this.props.errors.map((error, index) => (
                                <li key={this.props.name + "-error-" + index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
        );
    }
}