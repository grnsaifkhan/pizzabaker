
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

if (isset($_POST['submit'])) {

    $ingredName = $_POST['ingredname'];
    $regProvenance = $_POST['regprov'];
    $price = floatval($_POST['price']);
    $fromBaker = $_POST['frombaker'];
    $stockAmount = intval($_POST['stockamount']);
    $ingredIsShown = $_POST['ingredavail'];

    $sql = "select * from insert_ingredients('$ingredName', '$regProvenance', $price, '$fromBaker',  $stockAmount, '$ingredIsShown') ;";

    $result = pg_query($con, $sql);

}
if (isset($_POST['update'])) {
    $ingredId = $_POST['ingredid'];
    $ingredName = $_POST['ingredname'];
    $regProvenance = $_POST['regprov'];
    $price = floatval($_POST['price']);
    $fromBaker = $_POST['frombaker'];
    $stockAmount = intval($_POST['stockamount']);
    $ingredIsShown = $_POST['ingredavail'];

    $sql = "select * from update_ingredients('$ingredId','$ingredName', '$regProvenance', $price, '$fromBaker',  $stockAmount, '$ingredIsShown') ;";

    $result = pg_query($con, $sql);

}

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<body>
<?php include 'navigation.php'?>

<div class="container-fluid">
    <div class="content">

        <div style="margin: 15px">
            <div class="row" >
                <div class="col-12">
                    <?php
                    $query = "select * from get_order()";

                    $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                    $rowcount = pg_num_rows($rs);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            Customers orders
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Composition name</th>
                                    <th scope="col">Order time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($rs){

                                    $i=0;
                                    while($row = pg_fetch_row($rs)){
                                        $i++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $i ?></th>
                                            <?php $querycustomername = "select name from customers where id = $row[1]";
                                            $rescus = pg_query($con, $querycustomername);
                                            $rowcusdata = pg_fetch_row($rescus);?>
                                            <td><?php echo $rowcusdata[0] ?></td>
                                            <?php $queryingredname = "select pizza_size from pizza_compositions where id = $row[2]";
                                            $respizzacomp = pg_query($con, $queryingredname);
                                            $rowpizzacustomdata = pg_fetch_row($respizzacomp);?>
                                            <td><?php echo $rowpizzacustomdata[0] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>

