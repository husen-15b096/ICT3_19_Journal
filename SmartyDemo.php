<?php
require 'smarty/libs/Smarty.class.php';
$smarty = new Smarty();
require_once 'DbConfig.php';

//Query for Getting data from database
$qry = "SELECT * FROM categories";
if ($result = $mysqli->query($qry)) {
    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["cid"];
            $name = $row["Categorie"];

            $rows[] = $row; # $data is the array created for use in the Smarty template.

            //Assign PHP variable to Smarty template
            // $tpl->assign('rows', $rows);
            // $tpl->assign('cid', $cid);
            $smarty->assign('rows', $rows);
        }
        $smarty->display('templates/show.tpl');
    }
}
