<?php
session_start();
include '../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);
?>

<h2>Welcome, <?= $user['name'] ?>!</h2>
<p>Account No: <?= $user['account_no'] ?></p>
<p>Balance: ₹<?= $user['balance'] ?></p>

<a href="deposit.php">Deposit Money</a><br>
<a href="transfer_money.php">Transfer Money</a><br>
<a href="transaction_history.php">Transaction History</a><br>
<a href="logout.php">Logout</a>