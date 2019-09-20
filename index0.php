<?php
// Start the session
session_start();
$_SESSION["islogin"] = false;
function email_validation($str) {
    return (!preg_match(
"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str))
        ? FALSE : TRUE;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Welcome Back</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <style type="text/css">
    .wrapper {
      width: 650px;
      margin: 0 auto;
    }

    .page-header h2 {
      margin-top: 0;
    }

    table tr td:last-child a {
      margin-right: 15px;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

</head>

<body>

  <div class="wrapper">
    <div class="row justify-content-center">
      <div class="card" >
        <div class="card-body">
          <div class="col-12">
            <div class="page-header clearfix">
              <h2 class="pull-left">Customer Login</h2>
            </div>

            <?php
            require_once 'DbConfig.php';
            $username = "";
            $password = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

              $input_uname = trim($_POST["username"]);
              $input_pwd = trim($_POST["pwd"]);

              if (empty($input_uname)) {
                $uname_err = "Please enter a name.";
              } elseif (!email_validation($input_uname)) {
                $uname_err = "Please enter a valid name.";
              } else {
                $username = $input_uname;
              }

              if (empty($input_pwd)) {
                $pwd_err = "Please enter a Password.";
              } else {
                $password = $input_pwd;
              }


              //Query for Getting data from database
              $sql = "SELECT * FROM customer where email  = ?  AND password = ?";

              if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ss", $param_uname, $param_pwd);
                $param_uname = $username;
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
              <div class="form-group <?php echo (!empty($uname_err)) ? 'has-error' : ''; ?>">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <span class="help-block"><?php if (!empty($uname_err)) {
                                            echo $uname_err;
                                          } ?></span>
              </div>
              <div class="form-group <?php echo (!empty($pwd_err)) ? 'has-error' : ''; ?>">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password">

                <span class="help-block"><?php if (!empty($pwd_err)) {
                                            echo $pwd_err;
                                          } ?></span>
              </div>
              <input type="submit" class="btn btn-primary" value="Login" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
