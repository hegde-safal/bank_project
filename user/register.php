<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $account_no = "ACC" . rand(100000, 999999);
    $contact = $_POST['contact'];

    $sql = "INSERT INTO users (name, email, password, account_no, contact) 
            VALUES ('$name', '$email', '$password', '$account_no', '$contact')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="post">
  Name: <input type="text" name="name"><br>
  Email: <input type="email" name="email"><br>
  Password: <input type="password" name="password"><br>
  Contact: <input type="text" name="contact"><br>
  <input type="submit" value="Register">
</form>
</body>
</html>


