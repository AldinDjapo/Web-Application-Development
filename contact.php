<?php
$name = $_POST['name']?? '';
$subject = $_POST['subject']?? '';
$email = $_POST['email']?? '';
$message = $_POST['message']?? '';

if (!empty($name) || !empty($subject) || !empty($email) || !empty($message)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "aldin";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From registered Where email = ? Limit 1";
     $INSERT = "INSERT Into registered (name, subject, email, message) values(?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("i", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("iiii", $name, $subject, $email, $message);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All fields are required";
 die();
}
?>