<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Task</title>
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

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #dc3545; /* Bootstrap danger color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333; /* Darker shade for hover effect */
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
    <h2>Delete Task</h2>
    <form action="delete_task.php" method="POST">
        <input type="number" name="id" value="1" required placeholder="Enter Task ID">
        <button type="submit">Delete Task</button>
    </form>

    <?php
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];

        $sql = "DELETE FROM tasks WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p class='message success'>Task deleted successfully</p>";
        } else {
            echo "<p class='message error'>Error deleting task: " . $conn->error . "</p>";
        }
        
        $conn->close();
    }
    ?>
</div>

</body>
</html>
