<?php
session_start();
if (!$_SESSION["islogin"]) {
    header('Location: /ShoppingCart/index.php');
}
require 'Header.php';
require_once '../DbConfig.php';
$totalAmount = 0;
//Query for Getting data from database
// $qry = "SELECT  c.cartid ,c.custid ,c.pid,c.qty  ,p.pname ,p.price  from cart as c INNER JOIN products as p ON p.pid = c.pid WHERE custid=" . $_SESSION["custid"] . " GROUP BY p.pid ORDER BY product_count DESC";

$qry = "SELECT  c.cartid ,c.custid ,c.pid,c.qty  ,p.pname ,p.price  from cart as c INNER JOIN products as p ON p.pid = c.pid WHERE custid=" . $_SESSION["custid"] . " GROUP BY p.pid";
// $total=0;
if ($result = $mysqli->query($qry)) {
    if ($result->num_rows > 0) {

        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Cart Details</h2>
                    <a href="index.php" class="btn btn-success pull-right">Continew Shopping</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th scope="col">Product's</th>
                            <th scope="col">Total No Product's</th>
                            <th scope="col">Price One Item</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                while ($row = $result->fetch_array()) {
                                    //$qty = $row[]
                                    ?>
                            <tr>

                                <td><?php echo $row['pname']; ?></td>
                                <td><span class="badge badge-success"><?php echo $row['qty']; ?></span></td>
                                <td><span class="badge badge-success"><?php echo $row['price']; ?></span></td>
                                <td><?php $total = $row['price'] * $row['qty'];
                                                echo $total;
                                                // $gtotals = array($total);

                                                ?></td>

                                <td><?php echo "<a href='RemoveAll.php?pid=" . $row['pid'] . "&uid=" . $_SESSION["custid"] . "' title='Remove All' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                                echo "<a href='RemoveOne.php?pid=" . $row['pid'] . "&custid=" . $_SESSION["custid"] . "&qty=" . $row["qty"] . "' title='Remove One Record' data-toggle='tooltip'><span class='glyphicon glyphicon-minus'></span></a>";
                                                echo "<a href='AddToCartSingleItem.php?pid=" . $row['pid'] . "&custid=" . $_SESSION["custid"] . "&qty=" . $row["qty"] . "' title='Add One More' data-toggle='tooltip'><span class='glyphicon glyphicon-plus'></span></a>"; ?></td>

                            </tr>

                <?php

                        }
                    }
                }
                // echo "<div class='alert alert-danger' role='alert'>Cart Is Empty</div>";

                $result->free();
                // Close connection
                // $len = count($gtotals);
                // echo $len;
                // $totalAmount = 0;
                // for ($i = 0; $i < $len; $i++) {
                //     echo $i;
                //     $totalAmount = $totalAmount + $i;
                // }
                ?>
                <tr>

                    <th colspan="3">Total Amount <?php echo $totalAmount; ?></th>

                    <th></th>


                </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        $mysqli->close();
        require 'Footer.php';

        ?>