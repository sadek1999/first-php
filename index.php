<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
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

        .form-container {
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea,
        input[type="number"],
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

<div class="container">
    <h2>Task Management System</h2>

    <!-- Add Task Form -->
    <div class="form-container">
        <h3>Add a New Task</h3>
        <form action="" method="POST">
            <input type="text" name="title" placeholder="Task title" required>
            <textarea name="description" placeholder="Task description" required></textarea>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <?php
        include 'db_connect.php'; // Ensure db_connect.php is included

        // Handle Add Task Submission
        if (isset($_POST['add_task'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];

            // Use prepared statements for security
            $stmt = $conn->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, 'pending')");
            $stmt->bind_param("ss", $title, $description);

            // Execute the query and check for errors
            if ($stmt->execute()) {
                echo "<p class='message success'>New task created successfully!</p>";
            } else {
                echo "<p class='message error'>Error: " . $stmt->error . "</p>";
            }

            // Close the statement
            $stmt->close();
        }
        ?>
    </div>

    <!-- Update Task Form -->
    <div class="form-container">
        <h3>Update Task</h3>
        <form action="" method="POST">
            <input type="number" name="update_id" placeholder="Enter Task ID" required>
            <input type="text" name="update_title" placeholder="Enter Task Title" required>
            <textarea name="update_description" placeholder="Enter Task Description" required></textarea>
            <select name="update_status" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="in_progress">In Progress</option>
                <option value="on_hold">On Hold</option>
            </select>
            <button type="submit" name="update_task">Update Task</button>
        </form>

        <?php
        // Handle Update Task Submission
        if (isset($_POST['update_task'])) {
            $id = $_POST['update_id'];
            $title = $_POST['update_title'];
            $description = $_POST['update_description'];
            $status = $_POST['update_status'];

            // Update the task in the database
            $sql = "UPDATE tasks SET title=?, description=?, status=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $description, $status, $id);
            
            if ($stmt->execute()) {
                echo "<p class='message success'>Task updated successfully</p>";
            } else {
                echo "<p class='message error'>Error updating task: " . $stmt->error . "</p>";
            }
            
            // Close the statement
            $stmt->close();
        }
        ?>
    </div>

    <!-- Delete Task Form -->
    <div class="form-container">
        <h3>Delete Task</h3>
        <form action="" method="POST">
            <input type="number" name="delete_id" placeholder="Enter Task ID" required>
            <button type="submit" name="delete_task">Delete Task</button>
        </form>

        <?php
        // Handle Delete Task Submission
        if (isset($_POST['delete_task'])) {
            $id = $_POST['delete_id'];

            $sql = "DELETE FROM tasks WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo "<p class='message success'>Task deleted successfully</p>";
            } else {
                echo "<p class='message error'>Error deleting task: " . $stmt->error . "</p>";
            }
            
            // Close the statement
            $stmt->close();
        }
        ?>
    </div>

    <!-- View All Tasks -->
    <h3>All Tasks</h3>
    <?php
    // Fetch all tasks
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display tasks in a table
        echo '<table>';
        echo '<tr><th>ID</th><th>Title</th><th>Description</th><th>Status</th><th>Created At</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "<p class='message'>No tasks found.</p>";
    }

    // Close the connection
    $conn->close();
    ?>
</div>

</body>
</html>
