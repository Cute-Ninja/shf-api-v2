import React from "react";
import Client from '../../common/Api/Client/index';
import User from './details';
import UIkit from "uikit";

export default class Users extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            userToLoad: null,
            users: []
        };

        this.toggleUser = this.toggleUser.bind(this);
    }

    componentDidMount() {
        Client.getMany(
            "admin/api/users"
        ).then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    users: result.data
                });
            }
        );
    }

    toggleUser(username) {
        this.setState({userToLoad: username})
    }

    render() {
        const { error, isLoaded, userToLoad, users } = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div className="uk-grid">
                <div className="uk-width-1-2">
                    <div className="uk-card uk-card-default">
                        <table className="uk-table uk-table-divider uk-table-hover uk-table-middle uk-margin-remove-top">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Class / Level</th>
                                    <th>XP</th>
                                    <th>PA</th>
                                </tr>
                            </thead>
                            <tbody>
                            {users.map(user => (
                                <tr key={user.username} onClick={() => {this.toggleUser(user.username)}} className="shf-clickable-neutral">
                                    <td>{user.username}</td>
                                    <td>{user.character.class} - Lvl {user.character.level}</td>
                                    <td>{user.character.currentExperience}/{user.character.nextLevelExperience}XP</td>
                                    <td>{user.character.currentActionPoint}/{user.character.maxActionPoint}PA</td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                        <div className="uk-card-footer">
                            Pagination
                        </div>
                    </div>
                </div>
                <div className="uk-width-1-2">
                    <User username={userToLoad} />
                </div>
            </div>
        );
    }
}