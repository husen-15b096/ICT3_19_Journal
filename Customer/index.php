<?php
// Start the session
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/index.php');
}
require 'Header.php';
// Include config file
require_once '../DbConfig.php';
$qry = "SELECT * FROM products";

if (!empty($_GET["msg"])) {
  echo "<div class='alert alert-success' role='alert'>Successfully Added To Cart.</div>";
  
}

if ($result = $mysqli->query($qry)) {
  if ($result->num_rows > 0) {

?>

<div class="card-deck">

<?php
while ($row = $result->fetch_array()) {

 ?>
  <div class="card">
    <img class="card-img-top" width="260" height="180" src="..\Admin\Product\ProductPhoto\<?php  echo $row['photo']; ?>" alt="ProductPhoto">
    <div class="card-body">
      <h5 class="card-title"><?php echo $row['pname']; ?></h5>
      <p class="card-text"><?php echo $row['descr']; ?></p>
      <p class="card-text">    <a href="AddToCart.php?pid=<?php echo $row['pid']; ?>&custid=<?php echo $_SESSION["custid"] ; ?>" class="btn btn-primary">Add To Cart</a></small></p>
    </div>
  </div>
  &nbsp;&nbsp;

<?php
}
?>
</div>

<?php
}
}
 require 'Footer.php';
 ?>
