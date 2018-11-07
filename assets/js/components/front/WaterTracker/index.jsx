import React from 'react';
import UIkit from 'uikit';
import Client from "../../common/Api/Client/index";

export default class WaterTracker extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            waterTracker: null
        };

        this.deleteTrackerEntry = this.deleteTrackerEntry.bind(this);
    }

    componentDidMount() {
        Client.getOne("front/api/water-trackers", "today")
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        waterTracker: result
                    });
                }
            );
    }

    addTrackerEntry (trackerId) {
        UIkit.modal.prompt('Quantity :', '')
            .then((quantity) => {
                Client.post(
                    "front/api/water-trackers/" + trackerId + "/entries",
                    {quantity: quantity}
                )
                .then(result => {
                    UIkit.notification('Entry successfully added !', 'success');
                    this.setState({waterTracker: result});
                })
                .catch(error => {
                    UIkit.notification('An error has occurred ! (Code: ' + error + ')', 'danger');
                });
            });
    }

    deleteTrackerEntry (trackerId, entryId) {
        UIkit.modal.confirm('Are you sure you want to delete this entry ?')
            .then(() => {
                Client.deleteOne(
                    "front/api/water-trackers/" + trackerId + "/entries",
                    entryId
                )
                .then((result) => {
                    UIkit.notification('Entry successfully deleted !', 'success');
                    this.setState({waterTracker: result});
                });
            });
    }

    render() {
        const {isLoaded, waterTracker} = this.state;
        if (!isLoaded) {
            return <div>Loading...</div>;
        }

        return (
            <div id={waterTracker.id}>
                <div className="uk-card-header shf-remove-border-bottom">
                    <div className="uk-card-title uk-clearfix">
                        <div className="uk-float-left">
                            <h3>WaterTracker</h3>
                        </div>
                        <div className="uk-float-right water-tracker-score">
                            <span id="sum-drank">{waterTracker.sumDrank}</span> / {waterTracker.target}
                        </div>
                    </div>
                </div>

                <div className="uk-card-body uk-padding-remove-top">
                    <div className="water-tracker-entries uk-grid uk-child-width-1-3" uk-grid="true">
                        {waterTracker.entries.map(entry => (
                            <div key={entry.id} className="uk-margin-remove-bottom">
                                <div className="water-tracker-entry">
                                    <div className="uk-text-right entry-actions">
                                        <a className="uk-icon" uk-icon="icon: trash; ratio: 0.8"
                                           onClick={() => {this.deleteTrackerEntry(waterTracker.id, entry.id)}}></a>
                                    </div>
                                    <span className="water-tracker-entry-quantity">{entry.quantity} mL</span>
                                    <span className="water-tracker-entry-date">
                                        <span className="uk-icon" uk-icon="clock"></span>
                                        {new Date(entry.createdAt).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false})}
                                    </span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                <div className="uk-card-footer">
                    <a onClick={() => {this.addTrackerEntry(waterTracker.id)}} title="">Add new entry</a>
                </div>
            </div>
        );
    }
}