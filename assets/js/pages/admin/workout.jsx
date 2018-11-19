import React from 'react';
import ReactDOM from 'react-dom';
import CreateWorkout from "../../components/admin/Workouts/create";
import UpdateWorkout from "../../components/admin/Workouts/update";
import WorkoutSteps from "../../components/admin/WorkoutSteps/list";

let container = document.getElementById("workout-details");
let workoutId = container.getAttribute('data-workout-id');

if ("" === workoutId) {
    ReactDOM.render(
        <CreateWorkout workoutId={null} />,
        document.getElementById('workout')
    );
} else {
    ReactDOM.render(
        <UpdateWorkout workoutId={workoutId} />,
        document.getElementById('workout')
    );

    ReactDOM.render(
        <WorkoutSteps workoutId={workoutId} />,
        document.getElementById('workout-steps')
    );
}


