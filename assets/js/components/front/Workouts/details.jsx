import React from 'react';
import Client from '../../common/Api/Client/index';

export default class Workout extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            error: null,
            workout: null
        };
    }

    componentDidMount() {
        Client.getOne(
            "workouts",
            this.props.workoutId,
        )
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        workout: result
                    });
                }
            );
    }

    render() {
        const {error, isLoaded, workout} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div key={workout.id} className="uk-card uk-card-default uk-margin-bottom">
                <div className="uk-card-header shf-remove-border-bottom">
                    <h3 className="uk-text-uppercase">{workout.name}</h3>
                </div>
                <div className="uk-card-body">
                    BODY
                </div>
                <div className="uk-card-footer">
                    FOOTER
                </div>
            </div>
        );
    }
}