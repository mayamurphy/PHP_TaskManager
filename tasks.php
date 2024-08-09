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


                <!-- display tasks -->
                <div id="display-tasks">
                    <table id="tasks-table">
                    <?php
                        $lines = $dao->getAllTasks($_SESSION['user_id']);
                        foreach ($lines as $line) {
                            echo "<tr id=" . $line['task_id'] .
                            "><td id='tt-name'>" . htmlspecialchars($line['task_name']) .
                            "</td><td id='tt-status'>" . $line['task_status'] .
                            "</td><td><button id='editTaskButton' onclick='openEditTaskForm(" . $line['task_id'] . ")'>&#128393</button>".
                            "</td><td id='tt-description'>" . htmlspecialchars($line['task_description']) .
                            "</td><td id='tt-due-date'>" . date('m-d-Y',strtotime($line['task_due_date'])) . "</td></tr>";
                        
                            
                            // <!-- edit task form -->
                            echo "<div class='editTaskForm-container' id='". $line['task_id'] ."'>
                            <form id='editTaskForm'>
                                <label for='edit-task-name'>Task Name:</label>
                                <input type='text' id='edit-task-name' name='edit-task-name' value='" . htmlspecialchars($line['task_name']) . "'>
                                <label for='edit-task-description'>Task Description:</label>
                                <textarea rows='10' id='edit-task-description' name='edit-task-description' value=" . htmlspecialchars($line['task_description']) . "></textarea>
                                <label for='edit-task-due-date'>Task due date:</label>
                                <input type='date' id='edit-task-due-date' name='edit-task-due-date' value='" . date('Y-m-d',strtotime($line['task_due_date'])) ."'>
                                <p style='color:red'>!!!!!!!!!!!!! ADD STATUS CHANGE HERE !!!!!!!!!!!</p>
                                <button type='submit' id='submitEditTaskForm'>Save Task</button>
                            </form>
                            <button id='closeEditTaskForm' onclick='closeEditTaskForm(" . $line['task_id'] . ")'>Cancel</button></div>";
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>