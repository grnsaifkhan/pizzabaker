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

$supplierId = (int)$_GET['id'];
$action = $_GET['action'];

echo $action;
$update_sql = "select * from update_supplier(".$supplierId.",".$action.")";

$updateresult = pg_query($con, $update_sql);

if (!$updateresult) {

    echo '<script type="text/javascript"> alert("not updated"); </script>';

} else {

    header("location: supplier.php");



}

?>
