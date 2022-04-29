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
    if ($_POST['pizzasizeid'] == 'select' || $_POST['ingredid'] == 'select') {
        echo '<script type="text/javascript"> alert("Pizza Size or ingredient size is not selected");</script>';
    } else {
        $pizzaSizeId = $_POST['pizzasizeid'];
        $ingredientId = $_POST['ingredid'];
        $price = 0.0;
        $quantity = $_POST['quantity'];

        $query = "select * from ingredients where id = $ingredientId";

        $ingredPriceResult = pg_query($con, $query) or die("Cannot execute query: $query\n");

        if ($ingredPriceResult) {
            while ($row = pg_fetch_row($ingredPriceResult)) {
                $price = $row[3];
            }
        }

        $totalprice = floatval($price * $quantity);

        $composConfigQuery = "select * from insert_pizza_compositions_config('$pizzaSizeId','$ingredientId','$quantity','$totalprice')";

        $finalcompconfigresult = pg_query($con, $composConfigQuery);
    }

}

if (isset($_POST['order'])){
    if ($_POST['customerid'] == 'Select name'){
        echo '<script type="text/javascript"> alert("Customer name is not found");  window.location.href = "pizza_composition.php";</script>';
    }else{
        $compID = intval($_GET['compId']);
        $custID = intval($_POST['customerid']);

        $timezone = date_default_timezone_get();
        date_default_timezone_set($timezone);
        $date = date('Y-m-d H:i:s', time());

        $orderQuery = "select * from generate_order('$custID','$compID','$date')";
        $orderResult = pg_query($con, $orderQuery);

        if (!$orderResult) {

            echo '<script type="text/javascript"> alert("Order is denied"); </script>';

        } else {

            while($row = pg_fetch_row($orderResult)){
                $alertmessage = $row[0];
                if ($row[0] == 'Order Successfully created'){
                    echo '<script type="text/javascript"> alert("Order Successfully created");  window.location.href = "pizza_composition.php";</script>';
                }else {
                    echo '<script type="text/javascript"> alert("Stock out for this order");  window.location.href = "pizza_composition.php";</script>';
                }

            }



        }
    }

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
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Pizza Composition Form
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Pizza Size</label>
                                    <select class="form-select" aria-label="Default select example" name="pizzasizeid" required>
                                        <option selected>select</option>
                                        <?php
                                        $querypizzacomp = "select * from get_pizza_composition()";

                                        $compositoinres = pg_query($con, $querypizzacomp) or die("Cannot execute query: $querypizzacomp\n");
                                        if ($compositoinres){
                                            while($row = pg_fetch_row($compositoinres)){
                                                echo "<option value='". $row[0] ."'>" .$row[1] ."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Ingredients</label>
                                    <select class="form-select" aria-label="Default select example" name="ingredid">
                                        <option selected>select</option>
                                        <?php
                                        $querypizzacomp = "select * from get_avail_ingredients_with_morethan_zerostock() ";

                                        $compositoinres = pg_query($con, $querypizzacomp) or die("Cannot execute query: $querypizzacomp\n");
                                        if ($compositoinres){
                                            while($row = pg_fetch_row($compositoinres)){
                                                echo "<option value='". $row[0] ."'>" .$row[1]." -- ".$row[2]."  -- €".$row[3]."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="exampleInputText">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                <button type="submit" name="search" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <?php
                    if (isset($_POST['search']) || isset($_POST['submit'])){
                        if ($_POST['pizzasizeid']!='select'){
                            $pizzaSizeId = $_POST['pizzasizeid'];
                            $query = "select * from get_pizza_composition_config_details($pizzaSizeId);";
                            $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                            $rowcount = pg_num_rows($rs);

                            ?>
                            <div class="card">
                                <div class="card-header">
                                    Pizza Composition List
                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive">
                                        <thead>
                                        <tr>
                                            <th >#</th>
                                            <th >Ingredient</th>
                                            <th>Regional provenance</th>
                                            <th >quantity</th>
                                            <th >Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($rs){

                                            $i=0;
                                            $totalcomposprice = 0.0;
                                            while($row = pg_fetch_row($rs)){
                                                $i++;
                                                $totalcomposprice += $row[4];
                                                /*$queryingredname = "select name from ingredients where id = $row[2]";
                                                $res = pg_query($con, $queryingredname);
                                                $rowdata = pg_fetch_row($res);*/
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $row[5]  ?></td>
                                                    <td><?php echo $row[6]  ?></td>
                                                    <td><?php echo $row[3] ?></td>
                                                    <td>€<?php echo $row[4] ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="4">
                                                    <span class="text-right" style="float: right"><b>Total Price</b></span>
                                                </td>
                                                <td>
                                                    €<?php echo $totalcomposprice?>
                                                </td>
                                            </tr>

                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <br><br>
                                    <div class="mb-3">
                                        <form action="pizza_composition.php?compId=<?php echo $pizzaSizeId ?>" method="post">
                                            <div><p>Customer name</p></div>
                                            <select class="form-select" aria-label="Default select example" name="customerid">
                                                <option selected>Select name</option>
                                                <?php $cusQuery = "select * from get_all_customers()";
                                                $cusRes = pg_query($con, $cusQuery) or die("Cannot execute query: $query\n");
                                                if ($cusRes){
                                                    while($rowcusdata = pg_fetch_row($cusRes)){
                                                        echo "<option value='". $rowcusdata[0] ."'>" .$rowcusdata[1] ."</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <button type="submit" name="order" class="btn btn-primary">Order</button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }else{
                            echo '<script type="text/javascript"> alert("Pizza Size not selected");</script>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>

