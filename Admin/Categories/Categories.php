<?php
session_start();
if (!$_SESSION["islogin"]) {
  header('Location: /ShoppingCart/Admin/Login.php');
}
require '../Header.php';
require_once '../../DbConfig.php';

//Query for Getting data from database
$qry = "SELECT * FROM categories";
if ($result = $mysqli->query($qry)) {
  if ($result->num_rows > 0) {

    ?>
<div class="row">
  <div class="col-md-12">
    <div class="page-header clearfix">
      <h2 class="pull-left">Categorie Details</h2>
      <a href="CreateCategories.php" class="btn btn-success pull-right">Add New Categorie</a>
    </div>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Categories</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
            while ($row = $result->fetch_array()) {
              ?>
        <tr>
          <td><?php echo $row['cid']; ?></td>
          <td><?php echo $row['Categorie']; ?></td>
          <td><?php echo "<a href='ViewCategories.php?id=" . $row['cid'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='EditCategories.php?id=" . $row['cid'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='DeleteCategories.php?id=" . $row['cid'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>"; ?></td>
        </tr>
        <?php
            }
          } else {
            echo "<p class='lead'><em>No records were found.</em></p>";
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