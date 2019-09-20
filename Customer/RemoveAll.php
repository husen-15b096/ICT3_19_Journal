<?php
session_start();
if (!$_SESSION["islogin"]) {
    header('Location: /ShoppingCart/index.php');
}
// Process delete operation after confirmation
if (isset($_GET["pid"]) && isset($_GET["uid"]) && !empty($_GET["pid"]) && !empty($_GET["uid"])) {
    // Include config file
    require_once '../DbConfig.php';

    // Prepare a delete statement
    $sql = "DELETE FROM cart WHERE pid = ? AND custid = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ii", $param_pid,$param_custid);

        // Set parameters
        $param_pid = trim($_GET["pid"]);
          $param_custid = trim($_GET["uid"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records deleted successfully. Redirect to landing page
            header("location: Cart.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["pid"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
