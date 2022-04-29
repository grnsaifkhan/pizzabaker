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

    $supplierName = $_POST['suppliername'];
    $supplierIsShown = $_POST['isactive'];


    $sql = "select * from insert_suppliers('$supplierName', '$supplierIsShown') ;";

    $result = pg_query($con, $sql);

}

if (isset($_POST['update'])){
    $supplierId = $_POST['supplierid'];
    $supplierName = $_POST['suppliername'];

    $sql ="select * from update_supplier('$supplierId','$supplierName')";
    $result = pg_query($con,$sql);
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
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            New Supplier Form
                        </div>
                        <div class="card-body">
                            <form action="supplier.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Supplier name</label>
                                    <input type="text" class="form-control" name="suppliername" id="exampleInputText">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Supplier availability</label>
                                    <select class="form-select" aria-label="Default select example" name="isactive">
                                        <option selected>select</option>
                                        <option value="true">Avaialable</option>
                                        <option value="false">Unavailable</option>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            Supplier Update Form
                        </div>
                        <div class="card-body">
                            <form action="supplier.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Current supplier name</label>
                                    <select class="form-select" aria-label="Default select example" name="supplierid">
                                        <option selected>select</option>
                                        <?php
                                        $queryingred = "select * from get_all_suppliers('ALL')";

                                        $supplierres = pg_query($con, $queryingred) or die("Cannot execute query: $queryingred\n");
                                        if ($supplierres){
                                            while($row = pg_fetch_row($supplierres)){
                                                echo "<option value='". $row[0] ."'>" .$row[1] ."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Update supplier name</label>
                                    <input type="text" class="form-control" name="suppliername" id="exampleInputText">
                                </div>
                                <button name="update" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <?php
                    $query = "select * from get_all_suppliers('ALL')";

                    $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                    $rowcount = pg_num_rows($rs);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            Supplier List
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Supplier availability</th>
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
                                            <td><?php if ($row[2]=='t'){echo 'Available';}else{echo 'Unavailable';} ?></td>
                                            <td>
                                                <?php
                                                if ($row['2'] == 'f'){?>
                                                    <a href="actionsupplier.php?id=<?php echo $row[0];?>&action=<?php echo("true")?>"><button class="btn btn-success btn-sm">Show</button></a>
                                                    <?php

                                                }elseif ($row['2'] == 't'){?>
                                                    <a href="actionsupplier.php?id=<?php echo $row[0];?>&action=<?php echo("false")?>"><button class="btn btn-warning btn-sm">Hide</button></a>
                                                    <?php

                                                }
                                                ?>
                                                <a href="deletesupplier.php?id=<?php echo $row[0];?>"><button class="btn btn-danger btn-sm">Remove</button></a>
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
