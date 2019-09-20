<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <title>Welcome Back Bro</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="ShoppingStyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

  <?php
  function email_validation($str)
  {
    return (!preg_match(
      "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
      $str
    ))
      ? FALSE : TRUE;
  }

  function validate_mobile($mobile)
  {
    return preg_match('/^[0-9]{10}+$/', $mobile);
  }
  // Include config file
  require_once 'DbConfig.php';
  $custname = "";
  $email = "";
  $password = "";
  $username = "";
  $mobno = "";
  $cpassword = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_name = trim($_POST["custname"]);
    $input_username = trim($_POST["username"]);
    $input_email = trim($_POST["email"]);
    $input_mobno = trim($_POST["mobno"]);
    $input_password = trim($_POST["password"]);
    $input_cpassword = trim($_POST["cpassword"]);

    if (empty($input_name)) {
      $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
      $name_err = "Please enter a valid name.";
    } else {
      $custname = $input_name;
    }
    if (empty($input_username)) {
      $username_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
      $username_err = "Please enter a valid name.";
    } else {
      $username = $input_username;
    }

    if (empty($input_email)) {
      $email_err = "Please enter a name.";
    } elseif (!email_validation($input_email)) {
      $email_err = "Please enter a valid name.";
    } else {
      $email = $input_email;
    }

    if (empty($input_mobno)) {
      $mobno_err = "Please enter a name.";
    } elseif (!validate_mobile($input_mobno)) {
      $mobno_err = "Please enter a valid name.";
    } else {
      $mobno = $input_mobno;
    }

    if (empty($input_password)) {
      $password_err = "Please enter a name.";
    } else {
      $password = $input_password;
    }

    if (empty($input_cpassword)) {
      $cpassword_err = "Please enter a name.";
    } elseif ($password != $cpassword) {
      $cpassword_err = "Password Not Match.";
    } else {
      $cpassword = $input_cpassword;
    }

    if (empty($name_err) && empty($username_err) && empty($email_err) && empty($mobno_err) && empty($password_err)) {
      $sql = "INSERT INTO customer( cname, email, username, mobno, password) VALUES (?,?,?,?,?)";
      if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $param_cname, $param_email, $param_username, $param_mobno, $param_pwd);

        // Set parameters
        $param_cname = $custname;
        $param_email = $email;
        $param_username = $username;
        $param_mobno = $mobno;
        $param_pwd = $password;
        // Attempt to execute the prepared statement

        if ($stmt->execute()) {
          // Records created successfully. Redirect to landing page
          header("location: index.php");
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

  <div class="signup-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h2>Create Account</h2>
      <p class="lead">It's free and hardly takes more than 30 seconds.</p>
      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <div class="input-group ">
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
          <input type="text" class="form-control" name="username" placeholder="Username" required="required">
          <span class="help-block"><?php if (!empty($username_err)) {
                                      echo $username_err;
                                    } ?></span>
        </div>
      </div>
      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
          <input type="text" class="form-control" name="email" placeholder="Email Address" required="required">
          <span class="help-block"><?php if (!empty($email_err)) {
                                      echo $email_err;
                                    } ?></span>
        </div>
      </div>

      <div class="form-group <?php echo (!empty($mobno_err)) ? 'has-error' : ''; ?>">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
          <input type="number" class="form-control" name="mobno" placeholder="Mobile Number" required="required">
          <span class="help-block"><?php if (!empty($mobno_err)) {
                                      echo $mobno_err;
                                    } ?></span>
        </div>
      </div>

      <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
        <div class="input-group ">
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
          <input type="text" class="form-control" name="custname" placeholder="Name" required="required">
          <span class="help-block"><?php if (!empty($name_err)) {
                                      echo $name_err;
                                    } ?></span>
        </div>
      </div>
      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Password" required="required">
          <span class="help-block"><?php if (!empty($password_err)) {
                                      echo $password_err;
                                    } ?></span>
        </div>
      </div>
      <div class="form-group <?php echo (!empty($cpassword_err)) ? 'has-error' : ''; ?>">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-lock"></i>
            <i class="fa fa-check"></i>
          </span>
          <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" required="required">
          <span class="help-block"><?php if (!empty($cpassword_err)) {
                                      echo $cpassword_err;
                                    } ?></span>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
      </div>
      <p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>
    </form>
    <div class="text-center">Already have an account? <a href="index.php">Login here</a>.</div>
  </div>
</body>

</html>