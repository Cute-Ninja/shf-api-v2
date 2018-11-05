import React from "react";
import Client from "../../common/Api/Client";

export default class User extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            usernameToLoad: null,
            isLoaded: false,
            error: null,
            user: null
        }
    }

    componentDidUpdate() {
        if (this.props.username !== this.state.usernameToLoad) {
            this.setState({usernameToLoad: this.props.username});

            Client.getOne(
                "admin/api/users",
                this.props.username,
                {
                    "groups": ["lifecycle"]
                }
            ).then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        user: result
                    });
                }
            );
        }
    }

    render() {
        const { error, user } = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (null !== user) {
            return (
                <div className="uk-card uk-card-default">
                    <div className="uk-card-header shf-remove-border-bottom">
                        <div className="uk-grid-small uk-flex-middle uk-grid" uk-grid="true">
                            <div className="uk-width-auto uk-first-column">
                                <img className="uk-border-circle" src="http://via.placeholder.com/50x50" width="75" height="75" />
                            </div>
                            <div className="uk-width-expand">
                                <h3 className="uk-card-title uk-margin-remove-bottom">{user.username}</h3>
                                <p className="uk-text-meta uk-margin-remove-top">
                                    {user.email}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div className="uk-card-body uk-padding-remove-top">
                        <ul uk-tab="" className="uk-tab">
                            <li aria-expanded="true" className="uk-active"><a href="#">General</a></li>
                            <li aria-expanded="false" className=""><a href="#">Character</a></li>
                        </ul>

                        <div className="uk-switcher">
                            <div>
                                <ul>
                                    <li>{user.email}</li>
                                    <li>Registration: {new Date(user.createdAt).toLocaleDateString()}</li>
                                    <li>Last update: {new Date(user.updatedAt).toLocaleString()}</li>
                                    <li>Last login: {user.lastLogin ? new Date(user.lastLogin).toLocaleString() : null}</li>
                                </ul>
                            </div>
                            <div>
                                <ul>
                                    <li>{user.character.class} - Lvl {user.character.level}</li>
                                    <li>{user.character.currentExperience}/{user.character.nextLevelExperience}XP</li>
                                    <li>{user.character.currentActionPoint}/{user.character.maxActionPoint}PA</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }

        return(
            <i>Choose a user</i>
        );
    }
}