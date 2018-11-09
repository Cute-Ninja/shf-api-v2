import React from 'react';
import ReactDOM from 'react-dom';
import CreateWorkout from "../../components/admin/Workouts/create";
import UpdateWorkout from "../../components/admin/Workouts/update";

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
}


