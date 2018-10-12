import React from 'react';
import Client from "../../common/Api/Client/index";

export default class RegistrationConfirmation extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            isLoaded: false,
            successful: false,
        }
    }

    componentDidMount() {
        let url = new URL(window.location);
        Client.patch(
            'api/users/registration',
            'confirmation',
            {
                'confirmationKey': url.searchParams.get('key')
            }

        ).then(result => {
            this.setState({
                successful: true
            });
        });

        this.setState({
            isLoaded: true
        });
    }

    render() {
        if (!this.state.isLoaded) {
            return <div>Loading...</div>;
        }

        if (true === this.state.successful) {
            return (
                <div>
                    <h3>Félicitations & bienvenue</h3>
                    <p>
                        Et voilà, tu es officiellement un(e) apprenti(e) Super Héro !
                    </p>
                    <p>
                        Si il te reste encore un long chemin à parcourir avant de pouvoir arborer un collant bleu et une cape rouge, sache que tu es en bonne voie.
                    </p>

                    <p>
                        Tu peux te connecter pour accéder à tout nos services gratuitement.
                    </p>

                    <a href="/login" title="Accéder à la page de connexion" className="uk-button uk-button-primary">Se connecter</a>
                </div>
            );
        }

        return (
            <div>
                <h3>Une erreur est survenue</h3>
                <p>
                    Il semblerait que le lien d'activation qui t'as amené ici soit invalide.
                </p>
                <p>
                    Si celui-ci provient bien d'un email que nous t'avons envoyé n'hésite pas à contacter
                    le support via <strong>support@superherofactory.com</strong> afin qu'il puisse résoudre ce problème au plus vite.
                </p>
                <p>
                    En attendant, nous te présentons toutes nos excuses pour la gêne occasionnée.
                </p>
            </div>
        );
    }
}