<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="css/todo.css">
    </head>
        <?php require_once "header.php"?>
        
            <div id="tasks">
                tasks
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
                    <?php
                        require_once 'Dao.php';
                        $dao = new Dao();
                        $lines = $dao->getAllTasks($_SESSION['user_id']);
                        print_r($lines);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>