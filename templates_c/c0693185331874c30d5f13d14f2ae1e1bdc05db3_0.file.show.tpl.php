<?php
/* Smarty version 3.1.33, created on 2019-09-17 13:42:42
  from 'C:\wamp64\www\ShoppingCart\templates\show.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d80e2d21d1670_60314236',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0693185331874c30d5f13d14f2ae1e1bdc05db3' => 
    array (
      0 => 'C:\\wamp64\\www\\ShoppingCart\\templates\\show.tpl',
      1 => 1568727760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d80e2d21d1670_60314236 (Smarty_Internal_Template $_smarty_tpl) {
?><html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smarty SPA</title>
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"><?php echo '</script'; ?>
>
  <style type="text/css">
    .wrapper {
      width: 900px;
      margin: 0 auto;
    }

    .page-header h2 {
      margin-top: 0;
    }

    table tr td:last-child a {
      margin-right: 15px;
    }
  </style>
  <?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  <?php echo '</script'; ?>
>
  </head>
<body>
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
        </tr>
      </thead>
      <tbody>
      <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
              <?php
$__section_row_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['rows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_row_0_total = $__section_row_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_row'] = new Smarty_Variable(array());
if ($__section_row_0_total !== 0) {
for ($__section_row_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_row']->value['index'] = 0; $__section_row_0_iteration <= $__section_row_0_total; $__section_row_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_row']->value['index']++){
?>
                  <tr>
                       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_row']->value['index'] : null)], 'Value', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['Value']->value) {
?>
                       <td scope="col"><?php echo $_smarty_tpl->tpl_vars['Value']->value;?>
</td>
                  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>     
               </tr>
               <?php
}
}
?>
               <?php } else { ?>
               <h1>NO ROWS FOUND</h1>
               <?php }?> 
      </tbody>

      </table>
 
</body>
</html>
<?php }
}
