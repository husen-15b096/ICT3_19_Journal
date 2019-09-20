<?php
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/Admin/Login.php');
}

require '../Header.php';
require_once '../../DbConfig.php';

//Query for Getting data from database
$qry = "SELECT p.pid,p.pname,p.price,p.qty,p.photo,p.descr,p.available ,c.cid,c.Categorie FROM products as p LEFT Join categories c on p.cid=c.cid";

$qry1 = "SELECT * FROM products";
if ($result = $mysqli->query($qry)) {
  if ($result->num_rows > 0) {

    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="page-header clearfix">
          <h2 class="pull-left">Product's Details</h2>
          <a href="CreateProduct.php" class="btn btn-success pull-right">Add New Product</a>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Categorie</th>
              <th scope="col">Availability</th>
              <th scope="col">Photo</th>
              <th scope="col">Descr</th>
              <td>Action</td>

            </tr>
          </thead>
          <tbody>
            <?php
                while ($row = $result->fetch_array()) {
                  ?>
              <tr>
                <td><?php echo $row['pid']; ?></td>
                <td><?php echo $row['pname']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['Categorie']; ?></td>
                <td><?php echo $row['available']; ?></td>

                <td><?php echo $row['descr']; ?></td>
                <td> <img alt="Product Image" width="100" height="100" src="ProductPhoto/<?php echo $row['photo']; ?>" /></td>
                <td><?php echo "<a href='ViewProduct.php?id=" . $row['pid'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                          echo "<a href='EditProduct.php?id=" . $row['pid'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                          echo "<a href='DeleteProduct.php?id=" . $row['pid'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>"; ?></td>
              </tr>
        <?php
            }
          } else {
            echo '<a href="CreateProduct.php" class="btn btn-success pull-right">Add New Product</a><br><br>';
            echo '<div class="alert alert-danger" role="alert">
                No Such Records Found
              </div>';
          }
        } else {
          echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
        }
        ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
    $result->free();
    // Close connection
    $mysqli->close();
    require '../Footer.php';

    ?>