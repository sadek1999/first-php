<form action="delete_task.php" method="POST">
    <input type="number" name="id" value="1">
    <button type="submit">Delete Task</button>
</form>

<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM tasks WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
    
    $conn->close();
}
?>
