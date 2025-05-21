<?php
session_start();
require_once "../includes/db_connect.php";

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deposit_amount = floatval($_POST['amount']);
    
    if ($deposit_amount > 0) {
        // Update user's balance
        $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->bind_param("di", $deposit_amount, $user_id);
        $stmt->execute();
        $stmt->close();
        
        // Record transaction (sender_id NULL for deposit)
        $stmt2 = $conn->prepare("INSERT INTO transactions (sender_id, receiver_id, amount) VALUES (NULL, ?, ?)");
        $stmt2->bind_param("id", $user_id, $deposit_amount);
        $stmt2->execute();
        $stmt2->close();
        
        $message = "Deposit successful! ₹" . number_format($deposit_amount, 2);
    } else {
        $message = "Enter a valid amount greater than zero.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Deposit Money</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <h2>Deposit Money</h2>
    <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>
    
    <form method="POST">
        <label for="amount">Amount to Deposit (₹):</label>
        <input type="number" step="0.01" name="amount" id="amount" required min="1">
        <button type="submit">Deposit</button>
    </form>
    
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>