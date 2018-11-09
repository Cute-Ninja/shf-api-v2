import React from 'react';
import FormFieldComponent from "./_field";

export default class FormInputComponent extends FormFieldComponent {
    render() {
        let readOnly = this.props.readOnly === undefined ? false : this.props.readOnly;

        return (
            <div className="shf-form-field">
                <label className="uk-form-label" htmlFor={this.props.name}>
                    {this.props.label}
                </label>
                <div className=" uk-form-controls">
                    <input id={this.props.name} className="uk-input"
                           name={this.props.name} type={this.props.type} value={this.props.value}
                           disabled={readOnly} onChange={this.props.onUpdate} />
                </div>
            </div>
            /*
            <div className="shf-form-field">
                <label className="uk-form-label" htmlFor={this.props.name}>
                    {this.props.label}
                </label>
                <div className=" uk-form-controls">
                    <input id={this.props.name} name={this.props.name} value={this.props.value}
                           type={this.props.type} placeholder={this.props.placeholder}
                           onChange={this.handleInputChange}
                           className="uk-input" />
                    <span className="info">{info}</span>
                    <div id={this.props.name + '-error'}>
                        <ul>
                            {errors.map((error, index) => (
                                <li key={this.props.name + "-error-" + index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>*/
        );
    }
}