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

    $pizzaSize = $_POST['pizzasize'];

    $sql = "select * from insert_pizza_compositions('$pizzaSize')";

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
                            Base Pizza Form
                        </div>
                        <div class="card-body">
                            <form action="pizza_size.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Pizza size</label>
                                    <input type="text" class="form-control" name="pizzasize" id="exampleInputText" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <?php
                    $query = "select * from get_pizza_composition()";

                    $rs = pg_query($con, $query) or die("Cannot execute query: $query\n");


                    $rowcount = pg_num_rows($rs);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            Base pizza list
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pizza Size</th>
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

