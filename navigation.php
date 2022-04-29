<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">PizzaBaker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customer.php">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="allorders.php">Baker</a>
                </li>
                <?php
                    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
                    if ($curPageName == 'baker.php' || $curPageName== 'supplier.php' || $curPageName=='ingredient.php' || $curPageName=='ingred_and_supplier_info.php'|| $curPageName=='pizza_size.php' || $curPageName=='allorders.php' || $curPageName=='orderdetails.php' || $curPageName=='updateingredient.php'){
                        ?>

                        <div class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Baker menu
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="allorders.php">Customer orders</a></li>
                                    <li><a class="dropdown-item" href="ingredient.php">Ingredients</a></li>
                                    <li><a class="dropdown-item" href="supplier.php">Supplier info</a></li>
                                    <li><a class="dropdown-item" href="ingred_and_supplier_info.php">Supplier ingredient assortment</a></li>
                                    <li><a class="dropdown-item" href="pizza_size.php">Insert pizza size</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }?>
            </ul>
        </div>
    </div>
</nav>