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
  <title>Create New Product's</title>
</head>

<body>
  <?php
  require '../Header.php';
  // Include config file
  require_once '../../DbConfig.php';
  $pname = "";
  $cid = "";
  $price = "";
  $qty = "";
  $photoid = "";
  $photo = "";
  $descr = "";
  //$file_name="";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_name = trim($_POST["pname"]);
    $input_cid = trim($_POST["cid"]);
    $input_price = trim($_POST["price"]);
    $input_qty = trim($_POST["qty"]);
    $input_descr = trim($_POST["descr"]);
    $input_photo = $_FILES["photo"];
    // $input_photo = trim($_POST["photo"]);
    echo "CId" . $input_cid;

    if (empty($input_name)) {
      $name_err = "Please enter a name.";
    } else {
      $pname = $input_name;
    }

    if (empty($input_cid)) {
      $cid_err = "Select Categories.";
    } else {
      $cid = $input_cid;
    }
    if (empty($input_price)) {
      $price_err = "Please enter a Price.";
    } elseif (!ctype_digit($input_price)) {
      $price_err = "Please enter a positive integer value.";
    } else {
      $price = $input_price;
    }

    if (empty($input_qty)) {
      $qty_err = "Please enter a Quantity.";
    } elseif (!ctype_digit($input_qty)) {
      $qty_err = "Please enter a positive integer value.";
    } else {
      $qty = $input_qty;
    }

    if (empty($input_descr)) {
      $descr_err = "Please enter a Description.";
    } else {
      $descr = $input_descr;
    }


    if (empty($input_photo)) {
      $photo_err = "Please Select File .";
    } else {
      $photo = $input_photo;
    }

    if (empty($pname_err) && empty($cid_err) && empty($price_err) && empty($qty_err) && empty($descr_err)) {

      if (isset($_FILES['photo'])) {
        $errors = array();
        $file_name = $_FILES['photo']['name'];
        $file_size = $_FILES['photo']['size'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_type = $_FILES['photo']['type'];


        $file_ext = strtolower(end(explode('.', $_FILES['photo']['name'])));

        $extensions = array("jpeg", "jpg", "png");
        $randomName = generateRandomString();
        $photoName = $randomName . $file_name;
        // $photoName ="1.jpg";

        if (in_array($file_ext, $extensions) === false) {
          $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
          $errors[] = 'File size must be excately 2 MB';
        }

        if (empty($errors) == true) {
          move_uploaded_file($file_tmp, "ProductPhoto/" . $photoName);
          echo "Success";
        } else {
          print_r($errors);
        }
      }

      $sql = "INSERT INTO products(cid, pname, price, qty, photoid, photo, descr, available) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";

      if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssss", $para_cid, $param_pname, $para_price, $para_qty, $para_photoid, $para_photo, $para_descr, $para_isavailable);

        // Set parameters
        $para_cid = $cid;
        $param_pname = $pname;
        $para_price = $price;
        $para_qty = $qty;
        $para_photoid = 0;

        $para_photo = $photoName;
        $para_descr = $descr;
        $para_isavailable = 1;

        // if ($para_qty >= 1) {
        //   $para_isavailable = 1;
        // } else {
        //   $para_isavailable = 0;
        // }

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
          // Records created successfully. Redirect to landing page
          header("location: Products.php");
          exit();
        } else {
          echo "<div class='alert alert-danger' role='alert'>Something went wrong. Please try again later.</div>";
        }
      }
      // Close statement
      $stmt->close();
    }
  }
  ?>
  <div class="row">
    <div class="col-12">
      <div class="page-header clearfix">
        <h2 class="pull-left">Add New Product</h2>
        <a href="Categories.php" class="btn btn-success pull-right">Go Back To Products</a>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Product Name</label>
          <input type="text" value="<?php if (!empty($_POST['pname'])) {
                                      echo $_POST['pname'];
                                    } ?>" class="form-control" name="pname" aria-describedby="emailHelp" placeholder="Enter Product Name">
          <span class="help-block"><?php if (!empty($name_err)) {
                                      echo $name_err;
                                    } ?></span>
        </div>

        <div class="form-group <?php echo (!empty($cid_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Categories</label>
          <select class="form-control" name="cid">
            <option value="">--Select--</option>

            <?php
            $cateq = "SELECT * FROM categories";
            if ($result = $mysqli->query($cateq)) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {

                  ?>
                  <option value="<?php echo $row['cid'] ?>"><?php echo $row['Categorie'] ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Product Price</label>
          <input type="text" value="<?php if (!empty($_POST['price'])) {
                                      echo $_POST['price'];
                                    } ?>" class="form-control" name="price" aria-describedby="emailHelp" placeholder="Enter Product Price">
          <span class="help-block"><?php if (!empty($price_err)) {
                                      echo $price_err;
                                    } ?></span>
        </div>

        <div class="form-group <?php echo (!empty($qty_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Product Quantity</label>
          <input type="text" value="<?php if (!empty($_POST['qty'])) {
                                      echo $_POST['qty'];
                                    } ?>" class="form-control" name="qty" aria-describedby="emailHelp" placeholder="Enter Product Quantity">
          <span class="help-block"><?php if (!empty($qty_err)) {
                                      echo $qty_err;
                                    } ?></span>
        </div>

        <div class="form-group <?php echo (!empty($descr_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Product Description</label>
          <textarea type="text" value="<?php if (!empty($_POST['descr'])) {
                                          echo $_POST['descr'];
                                        } ?>" class="form-control" name="descr" aria-describedby="emailHelp" placeholder="Enter Product Name">
                                      <?php if (!empty($_POST['descr'])) {
                                        echo $_POST['descr'];
                                      } ?>
                                      </textarea>
          <span class="help-block"><?php if (!empty($descr_err)) {
                                      echo $descr_err;
                                    } ?></span>

        </div>

        <div class="form-group <?php echo (!empty($photo_err)) ? 'has-error' : ''; ?>">
          <label for="exampleInputEmail1">Select Product</label>
          <input type="file" class="form-control" name="photo" />
          <span class="help-block"><?php if (!empty($photo_err)) {
                                      echo $photo_err;
                                    } ?></span>

        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit">
        </div>
      </form>
    </div>
  </div>
  <?php
  // Close connection
  $mysqli->close();
  require '../Footer.php';
  ?>
</body>

</html>


<?php
function generateRandomString($length = 20)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>