<?php
// Start the session
session_start();
$_SESSION["islogin"] = false;
function email_validation($str)
{
  return (!preg_match(
    "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
    $str
  ))
    ? FALSE : TRUE;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

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
  <div class="signup-form">

    <?php
    require_once 'DbConfig.php';
    $email = "";
    $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $input_email = trim($_POST["email"]);
      $input_pwd = trim($_POST["password"]);

      if (empty($input_email)) {
        $email_err = "Please enter a name.";
      } elseif (!email_validation($input_email)) {
        $email_err = "Please enter a valid name.";
      } else {
        $email = $input_email;
      }

      if (empty($input_pwd)) {
        $password_err = "Please enter a Password.";
      } else {
        $password = $input_pwd;
      }


      //Query for Getting data from database
      $sql = "SELECT * FROM customer where email  = ?  AND password = ?";

      if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_email, $param_pwd);
        $param_email = $email;
        //$param_mobno = $username;
        $param_pwd = $password;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          $result = $stmt->get_result();

          if ($result->num_rows == 1) {
            /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // Retrieve individual field value
            //$_SESSION = ["uname"] = $row["username"];
            $_SESSION["islogin"] = true;
            $_SESSION["uname"] = $row['cname'];
            $_SESSION["custid"] = $row['cust_id'];
            header("location: /ShoppingCart/Customer/index.php");
          } else {
            echo '<div class="alert alert-danger" role="alert">
                        Invalid Username Or Password
                      </div>';
          }
        }
      } else {
        echo 'Some Error';
      }
    }
    ?>



    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <h2>Login into Your Account</h2>
      <p class="lead">login into your account to manage all your activity</p>

      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
          <input type="email" class="form-control" name="email" placeholder="Email Address" required="required">
          <span class="help-block"><?php if (!empty($email_err)) {
                                      echo $email_err;
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
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
      </div>
      <p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>
    </form>
    <div class="text-center">Not have an account? <a href="Registration.php">Sign here</a>.</div>
  </div>
</body>

</html>