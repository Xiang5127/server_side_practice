<?php
require_once("../config.php");

class Task{
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function getTasks(){
        if(!$this->connection){
            die("Database Connection Missing");
        }

        $query = 
        "SELECT * FROM tasks 
        ORDER BY created_at DESC";
        $result = mysqli_query($this->connection, $query);

        if(!$result){
            die("Database Query Failed: ". mysqli_error($this->connection));
        }

        // Fetch all row at once
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addTask($task, $description, $status){
        if(!$this->connection){
            die("Database Connection is Missing");
        }

        $title = mysqli_real_escape_string($this->connection, $task);
        $description = mysqli_real_escape_string($this->connection, $description);
        $status = mysqli_real_escape_string($this->connection, $status);

        $query = 
        "INSERT INTO task (title, description, status) 
        VALUES ('$title', '$$description', '$status')";

        if(!mysqli_query($this->connection, $query)){
            die("Insert Query Failed". mysqli_error($this->connection));
        }

        return true;
    }
}

?>