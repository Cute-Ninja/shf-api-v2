import React from 'react';
import Client from "../../common/Api/Client/index";
import FormComponent from "../../common/Form/form";
import FormFieldComponent from "../../common/Form/field";

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
            this.state.data
        ).then(result => {
            alert(result);
        })
        .catch(errors => {
            errors.then(errorResolved => {
                this.resolveErrors(errorResolved);
            });
        });
    }

    render() {
        if (!this.state.isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <form method="POST"  onSubmit={this.handleSubmit}>
                <FormFieldComponent type={'text'} name={'username'} placeholder="Nom d'utilisateur"
                                    data={this.state.data} errors={this.state.errors.username} />

                <FormFieldComponent type={'email'} name={'email'} placeholder="Email"
                                    data={this.state.data} errors={this.state.errors.email} />

                <FormFieldComponent type={'password'} name={'password'} placeholder="Mot de passe"
                                    info={'8 caractères minimum, au moins une majuscule, une minuscule et un chiffre.'}
                                    data={this.state.data} errors={this.state.errors.password} />

                <div>
                    <button className="uk-button uk-button-primary shf-margin-small" type="submit">S'inscrire</button>
                </div>
            </form>
        );
    }
}