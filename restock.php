<?php

/*$host = "localhost"; */
$host = "pgsql.hrz.tu-chemnitz.de";
/*$user = "postgres"; */
$user = "pizzabaker_rw";
/*$pass = "amd1234";*/
$pass = "ooch4iPh5th";
$db = "pizzabaker";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n");
$ingredientId = -99999;
if (isset($_GET['id'])){

    $ingredientId = (int)$_GET['id'];
}

$sql = "select * from restock_ingredients(".$ingredientId.")";

$result = pg_query($con, $sql);

if (!$result) {

    echo '<script type="text/javascript"> alert("not deleted"); </script>';

} else {

    while($row = pg_fetch_row($result)){
        $alertmessage = $row[0];
        if ($row[0] == 'SUCCESSFULLY RESTOCK THE INGREDIENTS'){
            echo '<script type="text/javascript"> alert("Successful restock");  window.location.href = "ingredient.php";</script>';
        }else {
            echo '<script type="text/javascript"> alert("Restock not possible");  window.location.href = "ingredient.php";</script>';
        }

    }



}

?>