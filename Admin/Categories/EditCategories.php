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
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            // Get hidden input value
            $id = $_POST["id"];

            $input_name = trim($_POST["Categori"]);
            if (empty($input_name)) {
                $name_err = "Please enter a name.";
            } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
                $name_err = "Please enter a valid name.";
            } else {
                $cname = $input_name;
            }

            if (empty($name_err)) {
                $sql = "UPDATE categories SET Categorie=? WHERE cid=?";
                if ($stmt = $mysqli->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("si", $param_cname, $param_cid);

                    // Set parameters
                    $param_cname = $cname;
                    $param_cid = $id;
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
    } else {
        // Check existence of id parameter before processing further
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Get URL parameter
            $cid =  trim($_GET["id"]);

            // Prepare a select statement
            $sql = "SELECT * FROM categories WHERE cid = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("i", $param_id);

                // Set parameters
                $param_id = $cid;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        // Retrieve individual field value
                        $name = $row["Categorie"];
                    } else {
                        // URL doesn't contain valid id. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            $stmt->close();

            // Close connection
            $mysqli->close();
        } else {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="page-header clearfix">
                <h2 class="pull-left">Edit Categorie</h2>
                <a href="Categories.php" class="btn btn-success pull-right">Go Back To Categorie</a>
            </div>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label for="exampleInputEmail1">Categori </label>
                    <input type="text" value="<?php echo $name; ?>" class="form-control" id="Categori" name="Categori" aria-describedby="emailHelp" placeholder="Enter Categories">
                    <span class="help-block"><?php if (!empty($name_err)) {
                                                    echo $name_err;
                                                } ?></span>
                </div>

                <input type="hidden" name="id" id="id" value="<?php echo $cid; ?>" />

                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>
    <?php
    require '../Footer.php';
    ?>
</body>

</html>