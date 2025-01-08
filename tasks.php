<!DOCTYPE html>
        <?php require_once "header.php"?>
        
            <div id="tasks">
                <p>tasks</p>
                
                <!-- add task form -->
                <button id="openAddTaskForm" onclick="openAddTaskForm()">Add Task</button>
                <form id="addTaskForm">
                    <label for="add-task-name">Task Name:</label>
                    <input type="text" id="add-task-name" name="add-task-name">
                    <label for="add-task-description">Task Description:</label>
                    <textarea rows="10" id="add-task-description" name="add-task-description"></textarea>
                    <label for="add-task-due-date">Task due date:</label>
                    <input type="date" id="add-task-due-date" name="add-task-due-date" value="<?php echo date('Y-m-d')?>">
                    <button type="submit" id="submitAddTaskForm">Add Task</button>
                    <button id="closeAddTaskForm">Cancel</button>
                </form>

                <!-- edit task form -->
                <form id="editTaskForm">
                    <input type="hidden" id="user-id" value="<?php echo $_SESSION['user_id']?>">
                    <input type="hidden" id="edit-task-id" name="edit-task-id">
                    <label for="edit-task-name">Task Name:</label>
                    <input type="text" id="edit-task-name" name="edit-task-name">
                    <label for="edit-task-description">Task Description:</label>
                    <textarea rows="10" id="edit-task-description" name="edit-task-description"></textarea>
                    <label for="edit-task-due-date">Task due date:</label>
                    <input type="date" id="edit-task-due-date" name="edit-task-due-date" value="<?php echo date('Y-m-d')?>">
                    <label for="edit-task-status">Task Status:</label>
                    <select id="edit-task-status" name="edit-task-status">
                        <option value="Not Started">Not Started</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>

                    <div id="buttons">
                        <button type="submit" id="submitEditTaskForm">Save Task</button>
                        <button id="deleteTask" onclick="deleteTask()">Delete Task</button>
                        <button id="closeEditTaskForm">Cancel</button>
                    </div>

                </form>

                <!-- display tasks -->
                <div id="display-tasks">
                    <table id="tasks-table">
                    <?php
                        $lines = $dao->getAllTasks($_SESSION['user_id']);
                        foreach ($lines as $line) {
                            echo "<tr id=" . $line['task_id'] .
                            "><td id='tt-name'>" . htmlspecialchars($line['task_name']) .
                            "</td><td id='tt-status'>" . $line['task_status'] .
                            "</td><td><button id='editTaskButton' 
                                    onclick='openEditTaskForm(`" . $line['task_id'] . "`,`"
                                        . $line['task_name'] . "`,`"
                                        . $line['task_description'] . "`,`"
                                        . $line['task_due_date'] . "`,`"
                                        . $line['task_status'] . "`)'>&#128393</button>".
                            "<td><button id='showExt' onclick='showExt(`". $line['task_id'] ."`)'>&#8595;</button>" .
                            "<button id='hideExt' onclick='hideExt(`". $line['task_id'] ."`)'>&#8593;</button>" .
                            "</td><td id='tt-desc-due'><p>". htmlspecialchars($line['task_description']) .
                            "</p><p>" . date('m-d-Y',strtotime($line['task_due_date'])) . "</p></td>";
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>