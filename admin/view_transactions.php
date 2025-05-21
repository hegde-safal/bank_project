<?php
session_start();
require_once "../includes/db_connect.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM transactions ORDER BY created_at DESC");

echo "<h2>All Transactions</h2>";
echo "<table border='1'><tr><th>ID</th><th>Sender</th><th>Receiver</th><th>Amount</th><th>Date</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['sender_id']}</td>
            <td>{$row['receiver_id']}</td>
            <td>{$row['amount']}</td>
            <td>{$row['created_at']}</td>
          </tr>";
}
echo "</table>";
?>
<br><a href="dashboard.php">Back to Dashboard</a>