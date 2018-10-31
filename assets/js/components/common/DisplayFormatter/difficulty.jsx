import React from 'react';

export default class Difficulty extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            stars: []
        }
    }

    componentDidMount() {
        let stars = [];
        let numberOfFull = Math.floor(this.props.value / 2);
        let hasHalf = 1 === (this.props.value % 2);
        for (let i = 0; i < 5; i++) {
            if (i < numberOfFull) {
                stars.push('star');
            } else if (i === numberOfFull && hasHalf) {
                stars.push('star_half');
            } else {
                stars.push('star_border');
            }
        }

        this.setState({
            isLoaded: true,
            stars: stars
        });
    }

    render() {
        const {isLoaded, stars} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div>
                {stars.map(star => (
                    <i className="material-icons">{star}</i>
                ))}
            </div>
        )
    }
}