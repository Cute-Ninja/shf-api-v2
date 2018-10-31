import React from 'react';
import DateUtils from "../../common/Utils/DateUtils";

export default class Duration extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            formattedDuration: null
        }
    }

    componentDidMount() {
        let [hours, minutes, seconds] = DateUtils.formatDurationAsArray(this.props.value);
        let formatted = '';
        if (hours > 0) {
            formatted = hours + 'h ';
        }

        if (minutes > 0) {
            formatted += minutes + 'min ';
        }

        if (seconds > 0 && minutes < 5) {
            formatted += seconds + 'sec ';
        }

        this.setState({
            isLoaded: true,
            formattedDuration: formatted
        })
    }

    render() {
        const {isLoaded, formattedDuration} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <span><i className="material-icons">timer</i> {formattedDuration}</span>
        )
    }
}