<?php
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/index.php');
}
// Include config file
require_once '../DbConfig.php';
$pid = $_GET["pid"];
$custid=$_GET["custid"];

if ($_SERVER["REQUEST_METHOD"] == "GET") {


  if (empty($name_err)) {
    $sql = "INSERT INTO cart(custid, pid,qty) VALUES (?,?,?)";
    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sss",$param_custid, $param_pid,$param_qty);

      // Set parameters
      $param_custid=$custid;
      $param_pid = $pid;
      $param_qty=1;
      // Attempt to execute the prepared statement

      if ($stmt->execute()) {

        echo "<div class='alert alert-danger' role='alert'>Successfully Added To Cart.</div>";


        header("location: index.php?msg=Successfully Added To Cart.");
        exit();
      } else {
        echo "<div class='alert alert-danger' role='alert'>Something went wrong. Please try again later.</div>";
      }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
  }
}
?>
