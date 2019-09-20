<?php
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/index.php');
}
// Include config file
require_once '../DbConfig.php';
$pid = $_GET["pid"];
$custid = $_GET["custid"];
$qty = $_GET["qty"];
if ($_SERVER["REQUEST_METHOD"] == "GET") {


  if (empty($name_err)) {
    $sql = "UPDATE cart set qty=? where custid=? AND pid=?";
    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sss", $param_qty, $param_custid, $param_pid);

      // Set parameters
      $param_qty = $qty + 1;
      $param_custid = $custid;
      $param_pid = $pid;
      // Attempt to execute the prepared statement

      if ($stmt->execute()) {

        //  echo "<div class='alert alert-danger' role='alert'>Successfully Added To Cart.</div>";

        header("location: Cart.php");
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
