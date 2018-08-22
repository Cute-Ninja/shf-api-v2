import React from 'react';
import ReactDOM from 'react-dom';
import Workout from '../../components/front/Workouts/details';

let element   = document.getElementById("workout");
let workoutId = element.getAttribute('data-workout-id');

ReactDOM.render(
    <Workout workoutId={workoutId} />,
    element
);
