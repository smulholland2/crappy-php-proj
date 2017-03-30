<?php

    $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
    mssql_select_db("newtap", $conn);

    $response["rows"] = [];
    $sql = "SELECT * FROM [ApprovedProctors]";
    $stmt = mssql_query ( $sql , $conn );
    if( $stmt === false ) {
        $this -> Failed(self::INVALIDQUERYEC);
    } else {
        while($row = mssql_fetch_assoc($stmt)) {                    
            array_push($response["rows"], $row);
        }        
    }
    $counties = [];
    $companies = [];
    for($i = 0; $i < count($response["rows"]); $i++)
    {
        isset($response["rows"][$i]["County"]) ? array_push($counties, $response["rows"][$i]) : array_push($companies, $response["rows"][$i]);
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Ohio Approved Proctors</h1>                
            </div>
            <div class="container">
                <div class="row">
                    <h2>Ohio State University Extension Offices</h2>
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>County</th>
                                <th>Educator</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Ext</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($i = 0; $i < count($counties); $i++) 
                                {
                                    $tr = "<tr>";
                                    $tr .= "<td>".$counties[$i]["County"]."</td>";
                                    $tr .= "<td>".$counties[$i]["Educator"]."</td>";
                                    $tr .= "<td><a href='mailto:".$counties[$i]["Email"]."'>".$counties[$i]["Email"]."</a></td>";
                                    $tr .= "<td><a href='".$counties[$i]["Phone"]."' class='visible-xs'>".$counties[$i]["Phone"]."</a><span class='hidden-xs'>".$counties[$i]["Phone"]."</span></td>";                                    
                                    $tr .= "<td>".$counties[$i]["Ext"]."</td>";
                                    $tr .= "</tr>";
                                    echo $tr;
                                }
                            ?>                                                    
                        </tbody>
                        <thead>
                            <tr>
                                <th>Other Statewide Providers</th>
                                <th>Educator</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Ext</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($i = 0; $i < count($companies); $i++) 
                                {
                                    $tr = "<tr>";
                                    $tr .= "<td>".$companies[$i]["Company"]."</td>";
                                    $tr .= "<td>".$companies[$i]["Educator"]."</td>";
                                    $tr .= "<td><a href='mailto:".$companies[$i]["Email"]."'>".$companies[$i]["Email"]."</a></td>";
                                    $tr .= "<td><a href='".$companies[$i]["Phone"]."' class='visible-xs'>".$companies[$i]["Phone"]."</a><span class='hidden-xs'>".$companies[$i]["Phone"]."</span></td>";
                                    $tr .= "<td>".$companies[$i]["Ext"]."</td>";
                                    $tr .= "</tr>";
                                    echo $tr;
                                }
                            ?>                                                    
                        </tbody>
                    </table>
                </div>
                <br />
            </div>            
            
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>