<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/discode/DiscodeController.php";

    $discode = new DiscodeController("list");
    $discodes = $discode -> ListDiscodes();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Add New Discode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>Discodes / 4u Pages</h1>
      </div>
      <a href="/discode/add" class="btn btn-success">Create New</a>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Discode</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php            
            for($i = 0; $i < count($discodes); $i++)
            {
                $discode_row = "<tr>";
                $discode_row .= "<td>";
                $discode_row .= "<a href=/4u/" . $discodes[$i]['discode'] . ">" . $discodes[$i]['discode'] . "</a>";
                $discode_row .= "</td>";
                $discode_row .= "<td>";
                $discode_row .= "<button class='btn btn-default' value='".$discodes[$i]['id']."'>Edit</button> | ";
                $discode_row .= "<button class='btn btn-danger' value='".$discodes[$i]['id']."'>Remove</button>";
                $discode_row .= "</td>";
                $discode_row .= "</tr>";

                echo $discode_row;
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>  