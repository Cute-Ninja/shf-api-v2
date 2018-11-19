import React from 'react';
import FormFieldComponent from "./_field";
import StringUtils from "../Utils/StringUtils";

export default class FormSelectComponent extends FormFieldComponent {
    render() {
        let nullable = this.props.nullable === undefined ? true : this.props.nullable;
        let readOnly = this.props.readOnly === undefined ? false : this.props.readOnly;
        let errors   = this.props.errors === undefined ? [] : this.props.errors;
        let info     = this.props.info === undefined ? "" : this.props.info;

        return (
            <div className="shf-form-field">
                <label className="uk-form-label" htmlFor={this.props.name}>
                    {this.props.label}
                </label>
                <div className="uk-form-controls">
                    <select id={this.props.name} name={this.props.name} value={this.props.value}
                            disabled={readOnly} onChange={this.props.onUpdate}
                            className="uk-select">

                        {true === nullable ? (<option value="">All</option>) : ''}

                        {this.props.options.map((option, index) => (
                            <option key={index} value={option.value ? option.value : option}>
                                {option.label ? option.label : StringUtils.ucfirst(option)}
                            </option>
                        ))}
                    </select>
                    <span className="info">{info}</span>
                    <div id={this.props.name + '-error'}>
                        <ul>
                            {errors.map((error, index) => (
                                <li key={this.props.name + "-error-" + index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
        );
    }
}