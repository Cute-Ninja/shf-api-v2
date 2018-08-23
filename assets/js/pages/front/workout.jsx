import React from 'react';
import ReactDOM from 'react-dom';
import Workout from '../../components/front/Workouts/details';
import WorkoutSteps from "../../components/front/WorkoutSteps/list";

let container = document.getElementById("workout-details");
let workoutId = container.getAttribute('data-workout-id');

ReactDOM.render(
    <Workout workoutId={workoutId} />,
    document.getElementById("workout")
);

ReactDOM.render(
    <WorkoutSteps workoutId={workoutId} />,
    document.getElementById("workout-steps")
);