import React from 'react';
import Client from "../../common/Api/Client/index";
import FormComponent from "../../common/Form/index";

export default class RegistrationForm extends FormComponent {
    constructor(props) {
        super(props);

        this.initializeState(['username', 'email', 'password']);
    }

    componentDidMount() {
        this.setState({
            isLoaded: true
        });
    }

    handleSubmit(event) {
        event.preventDefault();
        Client.post(
            "api/users/registration",
            {
                username: this.state.data.username,
                email: this.state.data.email,
                password: this.state.data.password
            }
        ).then(result => {
            alert(result);
        })
        .catch(error => {
            error.then(errorResolved => {
                console.log(errorResolved);
                this.setState({
                    errors: {
                        username: errorResolved.username
                    }
                });
            });
        });
    }

    render() {
        const {errors, isLoaded} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <form method="POST"  onSubmit={this.handleSubmit}>
                <div className="uk-margin">
                    <input id="username" name="username" value={this.state.data.username} onChange={this.handleInputChange}
                        className="uk-input" type="text" placeholder="Username" />
                    <div id="username-error"></div>
                </div>

                <div className="uk-margin">
                    <input id="email" name="email" value={this.state.data.email} onChange={this.handleInputChange}
                        className="uk-input" type="email" placeholder="Email" />
                    <div id="email-error"></div>
                </div>

                <div className="uk-margin">
                    <input id="password" name="password" value={this.state.data.password} onChange={this.handleInputChange}
                        className="uk-input" type="password" placeholder="Password" />
                    <div id="password-error"></div>
                </div>

                <div>
                    <button className="uk-button uk-button-primary shf-margin-small" type="submit">S'inscrire</button>
                </div>
            </form>
        );
    }
}