<?php
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/Admin/Login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Create New Categorie For Product's</title>
</head>

<body>
  <?php require '../Header.php';
  // Include config file
  require_once '../../DbConfig.php';
  $cname = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_name = trim($_POST["Categori"]);
    if (empty($input_name)) {
      $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
      $name_err = "Please enter a valid name.";
    } else {
      $cname = $input_name;
    }

    // Validate address
    // $input_address = trim($_POST["address"]);
    // if(empty($input_address)){
    //     $address_err = "Please enter an address.";
    // } else{
    //     $address = $input_address;
    // }

    if (empty($name_err)) {
      $sql = "INSERT INTO categories (Categorie) VALUES (?)";
      if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_cname);

        // Set parameters
        $param_cname = $cname;

        // Attempt to execute the prepared statement

        if ($stmt->execute()) {
          // Records created successfully. Redirect to landing page
          header("location: Categories.php");
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
  <div class="row">
    <div class="col-12">
      <div class="page-header clearfix">
        <h2 class="pull-left">Add New Categorie</h2>
        <a href="Categories.php" class="btn btn-success pull-right">Go Back To Categorie</a>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Categori </label>
          <input type="text" class="form-control" id="Categori" name="Categori" aria-describedby="emailHelp" placeholder="Enter Categories">
          <span class="help-block"><?php if (!empty($name_err)) {
                                      echo $name_err;
                                    } ?></span>
        </div>

        <input type="submit" class="btn btn-primary" value="Submit">
      </form>
    </div>
  </div>
  <?php
  require '../Footer.php';
  ?>
</body>

</html>