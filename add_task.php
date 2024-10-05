<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
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
        <h2>Add a New Task</h2>
        <form action="add_task.php" method="POST">
            <input type="text" name="title" placeholder="Task title" required>
            <textarea name="description" placeholder="Task description"></textarea>
            <button type="submit">Add Task</button>
            
        </form>

        <?php
        include 'db_connect.php'; // Ensure db_connect.php is included

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        // Close the connection
        $conn->close();
        ?>
    </div>

</body>
</html>
