<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            padding: 20px;
            color: #495057;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 40px;
        }

        input[type="text"],
        textarea,
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #17a2b8; /* Bootstrap info color */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #138496; /* Darker shade for hover effect */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #17a2b8; /* Bootstrap info color */
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }

        .message.success {
            color: #28a745;
        }

        .message.error {
            color: #dc3545;
        }

        /* Media Query for smaller screens */
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5rem;
            }

            input[type="text"], textarea, input[type="number"], select {
                font-size: 0.9rem;
            }

            button {
                font-size: 1rem;
            }

            th, td {
                padding: 8px;
            }
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

        <!-- PHP code for task management logic -->
        <?php
        include 'db_connect.php';

        // Handle Add Task Submission
        if (isset($_POST['add_task'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];

            // Prepared statement for security
            $stmt = $conn->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, 'pending')");
            $stmt->bind_param("ss", $title, $description);

            if ($stmt->execute()) {
                echo "<p class='message success'>New task created successfully!</p>";
            } else {
                echo "<p class='message error'>Error: " . $stmt->error . "</p>";
            }

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
        // Handle Update Task
        if (isset($_POST['update_task'])) {
            $id = $_POST['update_id'];
            $title = $_POST['update_title'];
            $description = $_POST['update_description'];
            $status = $_POST['update_status'];

            $sql = "UPDATE tasks SET title=?, description=?, status=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $description, $status, $id);
            
            if ($stmt->execute()) {
                echo "<p class='message success'>Task updated successfully</p>";
            } else {
                echo "<p class='message error'>Error updating task: " . $stmt->error . "</p>";
            }

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

            $stmt->close();
        }
        ?>
    </div>

    <!-- View All Tasks -->
    <h3>All Tasks</h3>
    <?php
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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

    $conn->close();
    ?>
</div>

</body>
</html>
