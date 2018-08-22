import React from 'react';
import ReactDOM from 'react-dom';
import WaterTrackerToday from '../../components/front/WaterTracker/index';
import UserWorkouts from '../../components/front/UserWorkouts/index';
import FavoriteWorkouts from '../../components/front/FavoriteWorkouts/index';

ReactDOM.render(
    <WaterTrackerToday />,
    document.getElementById('water-tracker')
);

ReactDOM.render(
    <UserWorkouts />,
    document.getElementById('scheduled-workouts')
);

ReactDOM.render(
    <FavoriteWorkouts />,
    document.getElementById('favorite-workouts')
);
