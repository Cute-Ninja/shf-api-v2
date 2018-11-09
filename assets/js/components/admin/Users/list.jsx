import React from "react";
import Client from '../../common/Api/Client/index';
import FormSelectComponent from "../../common/Form/select";
import FormInputComponent from "../../common/Form/input";
import FormComponent from "../../common/Form/_form";
import User from './details';

export default class Users extends FormComponent {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            userToLoad: null,
            users: [],
            usersCount: null
        };

        this.initializeState(['usernameLike', 'status']);

        this.toggleUser = this.toggleUser.bind(this);
    }

    handleSubmit(event) {
        if(undefined !== event) {
            event.preventDefault();
        }

        Client.getMany(
            "admin/api/users",
            this.state.data
        ).then(
            (result) => {
                this.setState({
                    isLoaded: true,
                    usernameToLoad: null,
                    users: result.data,
                    usersCount: result.count
                });
            }
        );
    }

    componentDidMount() {
        this.handleSubmit();
    }

    toggleUser(username) {
        this.setState({userToLoad: username})
    }

    render() {
        const { error, isLoaded, userToLoad, users, usersCount } = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                <form id="user-search-form" className="uk-card uk-card-default uk-form-stacked"
                      method="GET" onSubmit={this.handleSubmit}>
                    <div className="uk-card-header">
                        Users
                    </div>

                    <div className="uk-card-body">
                        <div className="uk-grid" uk-grid="true">
                            <div className="uk-width-1-3">
                                <FormInputComponent type={'text'} name={'usernameLike'} label="Username" placeholder="Partial name allowed"
                                                    data={this.state.data} errors={this.state.errors.usernameLike} />
                            </div>

                            <div className="uk-width-1-3">
                                <FormSelectComponent name={'status'} label="Status"
                                                     data={this.state.data} errors={this.state.errors.source} nullable={true}
                                                     options={['active', 'pending']} />
                            </div>
                        </div>
                    </div>

                    <div className="uk-card-footer uk-text-center">
                        <button className="uk-button uk-button-primary" type="submit">Search</button>
                        &nbsp;
                        <button className="uk-button uk-button-default" onClick={this.resetForm}>Reset</button>
                    </div>
                </form>

                <div className="uk-grid uk-margin-top">
                    <div className="uk-width-1-2">
                        <div className="uk-card uk-card-default">
                            <div className="uk-card-header">
                                {usersCount} user(s) found
                            </div>

                            <div className="uk-card-body">
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
                            </div>
                            <div className="uk-card-footer">
                                Pagination
                            </div>
                        </div>
                    </div>
                    <div className="uk-width-1-2">
                        <User username={userToLoad} />
                    </div>
                </div>
            </div>
        );
    }
}