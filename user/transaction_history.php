<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="C:\xampp\htdocs\bank_project\assets\style.css" />
</head>
<body>
<?php
session_start();
include '../includes/db_connect.php';
$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "
    SELECT * FROM transactions 
    WHERE sender_id = $user_id OR receiver_id = $user_id 
    ORDER BY timestamp DESC");

echo "<h2>Transaction History</h2>";
echo "<table border='1'><tr><th>Type</th><th>Amount</th><th>Description</th><th>Date</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    $type = $row['sender_id'] == $user_id ? 'Sent' : 'Received';
    echo "<tr>
        <td>$type</td>
        <td>₹{$row['amount']}</td>
        <td>{$row['description']}</td>
        <td>{$row['timestamp']}</td>
    </tr>";
}
echo "</table>";
?>
</body>
</html>


