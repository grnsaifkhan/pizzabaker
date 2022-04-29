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

    $availIngredId = $_POST['availingredid'];
    $availSupplierId = $_POST['availsupplierid'];
    $sql = "select * from insert_ingredients_assortment('$availIngredId','$availSupplierId')";

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
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Insert Ingredients and Suppliers Form
                        </div>
                        <div class="card-body">
                            <form action="ingred_and_supplier_info.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Avaialable Ingredient</label>
                                    <select class="form-select" aria-label="Default select example" name="availingredid" required>
                                        <option selected>select</option>

                                        <?php
                                        $queryingred = "select * from get_all_avail_ingred_for_supplier() ";

                                        $ingredres = pg_query($con, $queryingred) or die("Cannot execute query: $queryingred\n");
                                        if ($ingredres){
                                            while($row = pg_fetch_row($ingredres)){
                                                echo "<option value='". $row[0] ."'>" .$row[1] ."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Available supplier</label>
                                    <select class="form-select" aria-label="Default select example" name="availsupplierid" required>
                                        <option selected>select</option>
                                        <?php
                                        $queryingred = "select * from get_all_suppliers('active')";

                                        $supplierres = pg_query($con, $queryingred) or die("Cannot execute query: $queryingred\n");
                                        if ($supplierres){
                                            while($row = pg_fetch_row($supplierres)){
                                                echo "<option value='". $row[0] ."'>" .$row[1] ."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            Supplier and ingredient assortment List
                        </div>
                        <div class="card-body">
                                <form action="ingred_and_supplier_info.php" method="post">
                                    <div class="mb-3">
                                        <label for="exampleInputText" class="form-label">Available ingredients for suppliers</label>
                                        <select class="form-select" aria-label="Default select example" name="availIgredidforSupp" required>
                                            <option selected>select</option>
                                            <?php
                                            $queryingred = "select * from get_all_avail_ingred_for_supplier()";

                                            $supplierres = pg_query($con, $queryingred) or die("Cannot execute query: $queryingred\n");
                                            if ($supplierres){
                                                while($row = pg_fetch_row($supplierres)){
                                                    echo "<option value='". $row[0] ."'>" .$row[1] ."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-sm" name="show">show</button>
                                </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Suppliers name</th>
                                </tr>
                                </thead>
                            <?php
                            if (isset($_POST['show'])){
                                $ingredId = $_POST['availIgredidforSupp'];
                                $queryIngSup = "select * from get_available_suppliers_from_ing_assort('$ingredId')";

                                $resultIngwithSup = pg_query($con, $queryIngSup);

                                if ($resultIngwithSup){
                                    $i=0;
                                    while($row = pg_fetch_row($resultIngwithSup)){
                                        $i++;
                                        ?>
                                            <tbody>
                                            <tr>
                                                <th scope="row"><?php echo $i ?></th>
                                                <td><?php echo $row[1] ?></td>
                                            </tr>
                                            </tbody>

                                        <?php
                                    }
                                }

                            }
                            ?>
                            </table>
                        </div>
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

