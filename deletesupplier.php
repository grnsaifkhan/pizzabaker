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
$supplierIdForAssort = -1;
if (isset($_GET['id'])){
    $supplierIdForAssort = (int)$_GET['id'];
    $ingredientId = (int)$_GET['id'];
}
$delete_ingred_assort = "select * from delete_ingredient_assortment(null,'$supplierIdForAssort')";
pg_query($con, $delete_ingred_assort);
$delete_sql = "select * from delete_supplier(".$ingredientId.")";

$deleteresult = pg_query($con, $delete_sql);

if (!$deleteresult) {

    echo '<script type="text/javascript"> alert("Cannot be deleted"); </script>';

} else {

    header("location: supplier.php");



}

?>