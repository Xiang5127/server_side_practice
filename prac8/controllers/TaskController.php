<?php
// Controller is used to coordinate Model (logic) and View (ui)
// it routes request / inputs and decide what to do / show next

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../models/Task.php");

// global variable is defined outside
global $connection;

class TaskController{
    private $task;

    public function __construct($connection){
        $this->task = new Task($connection);
    }

    public function displayTask(){
        // Connect to Task and getTasks list
        global $connection;
        $tasks = $this->task->getTasks();
        
        // Call the View and display
        include(__DIR__ . "/../views/task_list.php");
    }

    public function addTask(){
        global $connection;

        if(isset($_POST["title"])){
            $title = $_POST["title"];
            $description = $_POST["description"];
            $status = $_POST["status"];

            // Connect to Task and addTask function
            if($this->task->addTask($title, $description, $status)){
                // head to add task view with success message
                header("Location: ../views/task_form.php?success=1");
                exit();
            }
        }
    }
}

    if (isset($_POST['submit'])) {
        global $con;
        $taskController = new TaskController($con);
        $taskController->addTask();
    }

?>