<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="number"],
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Update Task</h2>
    <form action="update_task.php" method="POST">
        <input type="number" name="id" placeholder="Enter Task ID" required>
        <input type="text" name="title" placeholder="Enter Task Title" required>
        <textarea name="description" placeholder="Enter Task Description" required></textarea>
        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="in_progress">In Progress</option>
            <option value="on_hold">On Hold</option>
        </select>
        <button type="submit">Update Task</button>
    </form>

    <?php
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Update the task in the database
        $sql = "UPDATE tasks SET title=?, description=?, status=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $status, $id);
        
        if ($stmt->execute()) {
            echo "<p class='message success'>Task updated successfully</p>";
        } else {
            echo "<p class='message error'>Error updating task: " . $stmt->error . "</p>";
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
</div>

</body>
</html>
