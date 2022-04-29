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

if (isset($_POST['update'])) {
    $ingredId = $_GET['ingredid'];
    $ingredName = $_POST['ingredname'];
    $regProvenance = $_POST['regprov'];
    $price = floatval($_POST['price']);
    $fromBaker = $_POST['frombaker'];
    $ingredIsShown = $_POST['ingredavail'];

    $sql = "select * from update_ingredients('$ingredId','$ingredName', '$regProvenance', $price, '$fromBaker', '$ingredIsShown') ;";

    $ingredupdateresult = pg_query($con, $sql);

    if (!$ingredupdateresult) {

        echo '<script type="text/javascript"> alert("Ingredient not updated"); </script>';

    } else {

        header("location: ingredient.php");



    }

}

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<body>
<?php include 'navigation.php'?>

<div class="container center-div">
    <div class="content">

        <div style="margin: 15px">
            <div class="row" >
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Ingredients Update Form
                        </div>
                        <div class="card-body">
                            <form action="updateingredient.php?ingredid=<?php echo $_GET['ingredid']?>" method="post">
                                <?php
                                    if (isset($_GET['ingredid'])){
                                        $ingredId = $_GET['ingredid'];
                                    $queryingred = "select * from ingredients where id = '$ingredId'";

                                    $ingredres = pg_query($con, $queryingred) or die("Cannot execute query: $queryingred\n");
                                    if ($ingredres){
                                        while($row = pg_fetch_row($ingredres)){
                                            ?>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Ingredient name</label>
                                                <input type="text" class="form-control" name="ingredname" value="<?php echo $row[1];?>" id="exampleInputText" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Regional Provenance</label>
                                                <input type="text" class="form-control" name="regprov" value="<?php echo $row[2];?>" id="exampleInputText" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Price</label>
                                                <input type="text" class="form-control" name="price" value="<?php echo $row[3];?>" id="exampleInputText" required>
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
                                                <label for="exampleInputText" class="form-label">Ingredient availability</label>
                                                <select class="form-select" aria-label="Default select example" name="ingredavail" required>
                                                    <option selected>select</option>
                                                    <option value="true">Available</option>
                                                    <option value="false">Unavailable</option>
                                                </select>
                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                            <?php
                                        }
                                    }
                                    }
                                ?>
                            </form>
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

