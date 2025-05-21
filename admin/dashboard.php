<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, Admin</h2>
<ul>
  <li><a href="view_users.php">View Users</a></li>
  <li><a href="view_transactions.php">View Transactions</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>