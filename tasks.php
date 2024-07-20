<!DOCTYPE html>
        <?php require_once "header.php"?>
        
            <div id="tasks">
                tasks
                <!-- add task form -->
                <button id="openAddTaskForm" onclick="openAddTaskForm()">Add Task</button>
                <button id="closeAddTaskForm" onclick="closeAddTaskForm()">X</button>
                <form id="addTaskForm">
                    <label for="task-name">Task Name:</label>
                    <input type="text" id="task-name" name="task-name">
                    <label for="task-description">Task Description:</label>
                    <textarea rows="10" id="task-description" name="task-description"></textarea>
                    <label for="task-due-date">Task due date:</label>
                    <input type="date" id="task-due-date" name="task-due-date" value="<?php echo date('Y-m-d')?>">
                    <button type="submit" id="submitAddTaskForm">Add Task</button>
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
                            "</td><td><button id='' onclick='openEditTaskForm(" . $line['task_id'] . ")'>&#128393</button>".
                            "</td><td id='tt-description'>" . htmlspecialchars($line['task_description']) .
                            "</td><td id='tt-due-date'>" . date('m-d-Y',strtotime($line['task_due_date'])) . "</td></tr>";
                        
                            
                            // <!-- edit task form -->
                            echo "<div class='editTaskForm-container' id='". $line['task_id'] ."'>
                            
                            <form id='editTaskForm'>
                                <label for='task-name'>Task Name:</label>
                                <input type='text' id='task-name' name='task-name' value='" . htmlspecialchars($line['task_name']) . "'>
                                <label for='task-description'>Task Description:</label>
                                <textarea rows='10' id='task-description' name='task-description' value=" . htmlspecialchars($line['task_description']) . "></textarea>
                                <label for='task-due-date'>Task due date:</label>
                                <input type='date' id='task-due-date' name='task-due-date' value='" . date('m-d-Y',strtotime($line['task_due_date'])) ."'>
                                <button type='submit' id='submitEditTaskForm'>Save Task</button>
                            </form></div>";
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>