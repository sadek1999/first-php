<form action="update_task.php" method="POST">
    <input type="number" name="id" value="1">
    <button type="submit">Mark as Completed</button>
</form>

<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "UPDATE tasks SET status='completed' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Task updated successfully";
    } else {
        echo "Error updating task: " . $conn->error;
    }
    
    $conn->close();
}
?>
