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
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            Ingredients Form
                        </div>
                        <div class="card-body">
                            <form action="ingredient.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Ingredient name</label>
                                    <input type="text" class="form-control" name="ingredname" id="exampleInputText" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Regional Provenance</label>
                                    <input type="text" class="form-control" name="regprov" id="exampleInputText" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price" id="exampleInputText" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Provider Availability</label>
                                    <select class="form-select" aria-label="Default select example" name="frombaker" required>
                                        <option selected>select</option>
                                        <option value="true">PizzaBaker</option>
                                        <option value="false">Supplier</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Stock amount</label>
                                    <input type="number" class="form-control" name="stockamount" id="exampleInputText" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Ingredient availability</label>
                                    <select class="form-select" aria-label="Default select example" name="ingredavail" required>
                                        <option selected>select</option>
                                        <option value="true">Available</option>
                                        <option value="false">Unavailable</option>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <?php
                    $query = "select * from get_all_ingredients()";

                    $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                    $rowcount = pg_num_rows($rs);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            Ingredients List
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Regional Provenance</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Ingredient provider</th>
                                    <th scope="col">Stock amount</th>
                                    <th scope="col">Ingredient available</th>
                                    <th scope="col">Action</th>
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
                                                <td><?php echo $row[1] ?></td>
                                                <td class="col-md-1"><?php echo $row[2] ?></td>
                                                <td><?php echo $row[3] ?>€</td>
                                                <td class="col-md-1"><?php if ($row[4]=='t'){echo 'PizzaBaker';}else{echo 'Supplier';} ?></td>
                                                <td><?php echo $row[5] ?></td>
                                                <td class="col-md-1"><?php if ($row[6]=='t'){echo 'Avaialable';}else{echo 'Unavailable';} ?></td>
                                                <td>
                                                    <a href="updateingredient.php?ingredid=<?php echo $row[0];?>"><button class="btn btn-success btn-sm">Update</button></a>
                                                    <?php
                                                        if ($row['6'] == 'f'){?>
                                                            <a href="actioningredient.php?id=<?php echo $row[0];?>&action=<?php echo("true")?>"><button class="btn btn-success btn-sm">Show</button></a>
                                                            <?php

                                                        }elseif ($row['6'] == 't'){?>
                                                            <a href="actioningredient.php?id=<?php echo $row[0];?>&action=<?php echo("false")?>"><button class="btn btn-warning btn-sm">Hide</button></a>
                                                            <?php

                                                        }
                                                    ?>
                                                    <a href="deleteingredient.php?id=<?php echo $row[0];?>"><button class="btn btn-danger btn-sm">Remove</button></a>
                                                    <a href="restock.php?id=<?php echo $row[0];?>"><button class="btn btn-primary btn-sm">Restock</button></a>
                                                </td>
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

