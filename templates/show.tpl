<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smarty SPA</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
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
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
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
      {if $rows}
              {section name=row loop=$rows}
                  <tr>
                       {foreach from=$rows[row] key="key" item="Value"}
                       <td scope="col">{$Value}</td>
                  {/foreach}     
               </tr>
               {/section}
               {else}
               <h1>NO ROWS FOUND</h1>
               {/if} 
      </tbody>

      </table>
 
</body>
</html>
