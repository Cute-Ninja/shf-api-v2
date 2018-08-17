import React from "react";
import User from './User';

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
        fetch("http://127.0.0.1:8001/admin/api/users", {credentials: 'same-origin'})
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        users: result
                    });
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
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
                        <div className="uk-card-header shf-remove-border-bottom">
                            <h3 className="uk-card-title">Users</h3>
                        </div>
                        <table className="uk-table uk-table-divider uk-table-hover uk-table-middle uk-margin-remove-top">
                            <thead>

                            </thead>
                            <tbody>
                            {users.map(user => (
                                <tr key={user.username} onClick={() => {this.toggleUser(user.username)}} className="shf-clickable-neutral">
                                    <td>{user.username}</td>
                                    <td>{user.status}</td>
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