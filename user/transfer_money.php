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

$sender_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiver_acc = $_POST['receiver_account'];
    $amount = floatval($_POST['amount']);
    $desc = $_POST['description'];

    // Get receiver ID
    $receiver_query = mysqli_query($conn, "SELECT id FROM users WHERE account_no = '$receiver_acc'");
    $receiver = mysqli_fetch_assoc($receiver_query);

    if (!$receiver) {
        echo "Receiver not found!";
        exit;
    }

    $receiver_id = $receiver['id'];

    // Get sender balance
    $sender_result = mysqli_query($conn, "SELECT balance FROM users WHERE id = $sender_id");
    $sender = mysqli_fetch_assoc($sender_result);

    if ($sender['balance'] >= $amount) {
        // Begin transaction
        mysqli_begin_transaction($conn);

        // Deduct from sender
        mysqli_query($conn, "UPDATE users SET balance = balance - $amount WHERE id = $sender_id");

        // Add to receiver
        mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE id = $receiver_id");

        // Record transaction
        mysqli_query($conn, "INSERT INTO transactions (sender_id, receiver_id, amount, description) 
                            VALUES ($sender_id, $receiver_id, $amount, '$desc')");

        mysqli_commit($conn);
        echo "Transfer successful!";
    } else {
        echo "Insufficient balance!";
    }
}
?>

<form method="post">
  Receiver Account No: <input type="text" name="receiver_account"><br>
  Amount: <input type="number" step="0.01" name="amount"><br>
  Description: <input type="text" name="description"><br>
  <input type="submit" value="Transfer">
</form>
</body>
</html>

