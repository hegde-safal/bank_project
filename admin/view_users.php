<?php
session_start();
require_once "../includes/db_connect.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
echo "<h2>All Users</h2>";
echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Balance</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['balance']}</td>
          </tr>";
}
echo "</table>";
?>
<br><a href="dashboard.php">Back to Dashboard</a>