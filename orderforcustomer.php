
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
$customer_id= -9999;
if (isset($_GET['cusId'])){
    $customer_id = $_GET['cusId'];
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
                    $query = "select * from orders where customer_id = $customer_id order by created_on desc ";

                    $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                    $rowcount = pg_num_rows($rs);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            Recent orders
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Pizza Composition Name</th>
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
                        <div class="card-body">
                            <a href="pizza_composition.php"><button class="btn btn-success btn-sm">Create new order</button></a>
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

