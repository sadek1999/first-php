<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tasks</title>
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
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Tasks</h2>

    <?php
    include 'db_connect.php';

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
