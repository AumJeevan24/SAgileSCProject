<!--kanban Page-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Drag & Drop API</title>

    <link rel="stylesheet" href="{{ asset('styles.css') }}" />

</head>
<body>
<div class="board">
        <button id="add-lane-btn">Add New Lane</button>

        <div class="lanes">
            @foreach ($statuses as $status)
                <?php
                $taskList = $tasksByStatus[$status->id] ?? [];
                ?>
                <div class="swim-lane">
                    <h3 class="heading">{{ $status->title }}</h3>
                    

                        <button type="button" class="rename-btn">Rename</button>
 

                        <button type="button" class="delete-btn">Delete</button>


                    <form class="form">
                        <input type="text" placeholder="New Task..." class="new-input" />
                        <button type="submit" class="new-submit-btn">Add +</button>
                    </form>
                    
                    @foreach ($taskList as $task)
                        <p class="task" draggable="true">{{ $task->title }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <script>
        
    //Function to handle common logic for creating a new task element
    function createTaskElement(value) {
    const newTask = document.createElement("p");
    newTask.classList.add("task");
    newTask.setAttribute("draggable", "true");
    newTask.innerText = value;

    newTask.addEventListener("dragstart", () => {
        newTask.classList.add("is-dragging");
    });

    newTask.addEventListener("dragend", () => {
        newTask.classList.remove("is-dragging");
    });

    return newTask;
    }
    

    // Function to handle common logic for handling drag and drop events
    function handleDragDropEvents(sourceLane, targetLane) {
    sourceLane.addEventListener("dragover", (e) => {
        e.preventDefault();
        const draggingTask = document.querySelector(".is-dragging");

        if (draggingTask) {
        sourceLane.classList.add("drag-over");
        }
    });

    sourceLane.addEventListener("dragleave", () => {
        sourceLane.classList.remove("drag-over");
    });

    sourceLane.addEventListener("drop", (e) => {
        e.preventDefault();
        sourceLane.classList.remove("drag-over");

        const draggingTask = document.querySelector(".is-dragging");

        if (draggingTask) {
        targetLane.appendChild(draggingTask);
        draggingTask.classList.remove("is-dragging");
        }
    });
    }

    // Function to change the lane name
    function changeLaneName(lane, newName) {
    const heading = lane.querySelector(".heading");
    heading.innerText = newName;
    }

    document.addEventListener("DOMContentLoaded", () => {
    const todoform = document.getElementById("todo-form");
    const doingform = document.getElementById("doing-form");
    const doneform = document.getElementById("done-form");
    const todoInput = document.getElementById("todo-input");
    const doingInput = document.getElementById("doing-input");
    const doneInput = document.getElementById("done-input");
    const todoLane = document.getElementById("todo-lane");
    const doingLane = document.getElementById("doing-lane");
    const doneLane = document.getElementById("done-lane");
    const addLaneBtn = document.getElementById("add-lane-btn");
    const renameTodoBtn = document.getElementById("rename-todo-btn");
    const renameDoingBtn = document.getElementById("rename-doing-btn");
    const renameDoneBtn = document.getElementById("rename-done-btn");
    const deletetodoBtn = document.getElementById("delete-todo-btn");
    const deletedoingBtn = document.getElementById("delete-doing-btn");
    const deletedoneBtn = document.getElementById("delete-done-btn");


    const renameBtns = document.querySelectorAll(".rename-btn");
            const deleteBtns = document.querySelectorAll(".delete-btn");

            renameBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const newName = prompt("Enter new name for the lane:");

                    if (newName !== null) {
                        const lane = btn.closest(".swim-lane");
                        changeLaneName(lane, newName);
                    }
                });
            });

            deleteBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const lane = btn.closest(".swim-lane");
                    lane.remove();
                });
            });


            const newSubmitBtns = document.querySelectorAll(".new-submit-btn");

newSubmitBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();
        const lane = btn.closest(".swim-lane");
        const newInput = lane.querySelector(".new-input");
        const value = newInput.value;

        if (value.trim() !== "") {
            const newTask = createTaskElement(value);
            lane.appendChild(newTask);
            newInput.value = "";
        }
    });
});

    // Function to create a new lane
    function createNewLane(laneName) {
                const newLane = document.createElement("div");
                newLane.classList.add("swim-lane");

                const newHeading = document.createElement("h3");
                newHeading.classList.add("heading");
                newHeading.innerText = laneName;

                const renameForm = document.createElement("form");
                const renameBtn = document.createElement("button");
                renameBtn.setAttribute("type", "button");
                renameBtn.innerText = "Rename";
                renameForm.appendChild(renameBtn);

                const deleteForm = document.createElement("form");
                const deleteBtn = document.createElement("button");
                deleteBtn.setAttribute("type", "button");
                deleteBtn.innerText = "Delete";
                deleteForm.appendChild(deleteBtn);

                const newForm = document.createElement("form");
                const newInput = document.createElement("input");
                newInput.setAttribute("type", "text");
                newInput.setAttribute("placeholder", "New Task...");
                const newSubmitBtn = document.createElement("button");
                newSubmitBtn.setAttribute("type", "submit");
                newSubmitBtn.innerText = "Add +";

                newForm.appendChild(newInput);
                newForm.appendChild(newSubmitBtn);

                newLane.appendChild(newHeading);
                newLane.appendChild(renameBtn);
                newLane.appendChild(deleteBtn);
                newLane.appendChild(newForm);

                document.querySelector(".lanes").appendChild(newLane);

                // Add event listener for submitting new tasks in the new lane
                newForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    const value = newInput.value;

                    if (!value) return;

                    const newTask = createTaskElement(value);

                    newLane.appendChild(newTask);

                    newInput.value = "";
                });

                // Add event listener for renaming the lane
                renameBtn.addEventListener("click", () => {
                    const newName = prompt("Enter new name for the lane:");

                    if (newName !== null) {
                        changeLaneName(newLane, newName);
                    }
                });

                // Add event listener for deleting the lane
                deleteBtn.addEventListener("click", () => {
                    newLane.remove();
                });

                // Call the function to handle drag and drop events for the new lane
                handleDragDropEvents(newLane, newLane);
            }

            

            // Add event listener for adding a new lane
            addLaneBtn.addEventListener("click", () => {
                const newLaneName = prompt("Enter the name for the new lane:");
                if (newLaneName !== null) {
                    createNewLane(newLaneName);
                }
            });


    //create new Lane
    

    // Add event listener for renaming existing lanes
    renameTodoBtn.addEventListener("click", () => {
        const newName = prompt("Enter new name for the lane:");

        if (newName !== null) {
        changeLaneName(todoLane, newName);
        }
    });

    renameDoingBtn.addEventListener("click", () => {
        const newName = prompt("Enter new name for the lane:");

        if (newName !== null) {
        changeLaneName(doingLane, newName);
        }
    });

    renameDoneBtn.addEventListener("click", () => {
        const newName = prompt("Enter new name for the lane:");

        if (newName !== null) {
        changeLaneName(doneLane, newName);
        }
    });

    // Add event listener for submitting new tasks in the existing lanes
    todoform.addEventListener("submit", (e) => {
        e.preventDefault();
        const value = todoInput.value;

        if (!value) return;

        const newTask = createTaskElement(value);

        todoLane.appendChild(newTask);

        todoInput.value = "";
    });

    doingform.addEventListener("submit", (e) => {
        e.preventDefault();
        const value = doingInput.value;

        if (!value) return;

        const newTask = createTaskElement(value);

        doingLane.appendChild(newTask);

        doingInput.value = "";
    });

    doneform.addEventListener("submit", (e) => {
        e.preventDefault();
        const value = doneInput.value;

        if (!value) return;

        const newTask = createTaskElement(value);

        doneLane.appendChild(newTask);

        doneInput.value = "";
    });

    deletetodoBtn.addEventListener("click", () => {
        todoLane.remove();
    });

    deletedoingBtn.addEventListener("click", () => {
        doingLane.remove();
    });

    deletedoneBtn.addEventListener("click", () => {
        doneLane.remove();
    });

    // Call the function to handle drag and drop events for existing lanes
    handleDragDropEvents(todoLane, todoLane);
    handleDragDropEvents(doingLane, doingLane);
    handleDragDropEvents(doneLane, doneLane);
    });

    //////////////////////////////////////////////////////////////////////

    const draggables = document.querySelectorAll(".task");
    const droppables = document.querySelectorAll(".swim-lane");

    draggables.forEach((task) => {
    task.addEventListener("dragstart", () => {
        task.classList.add("is-dragging");
    });
    task.addEventListener("dragend", () => {
        task.classList.remove("is-dragging");
    });
    });

    droppables.forEach((zone) => {
    zone.addEventListener("dragover", (e) => {
        e.preventDefault();

        const bottomTask = insertAboveTask(zone, e.clientY);
        const curTask = document.querySelector(".is-dragging");

        if (!bottomTask) {
        zone.appendChild(curTask);
        } else {
        zone.insertBefore(curTask, bottomTask);
        }
    });
    });

    const insertAboveTask = (zone, mouseY) => {
    const els = zone.querySelectorAll(".task:not(.is-dragging)");

    let closestTask = null;
    let closestOffset = Number.NEGATIVE_INFINITY;

    els.forEach((task) => {
        const { top } = task.getBoundingClientRect();

        const offset = mouseY - top;

        if (offset < 0 && offset > closestOffset) {
        closestOffset = offset;
        closestTask = task;
        }
    });

    return closestTask;
    };


    </script>
</body>
</html>
