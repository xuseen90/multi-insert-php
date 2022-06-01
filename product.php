<?php include('connection.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-6 mt-3">
                <h3 class="text-muted">list All of Product</h3>
            </div>
            <div class="col-6 text-end mt-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
                    Add Product
                </button>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT p_id ID, pro_name ProdectName, name CustomerName , qountity Qountity, Price SubTotal from prodect p , customer c where p.cut_id=c.cus_id";
    $result = mysqli_query($connection, $sql);
    $feilds = $result->fetch_fields()

    ?>

    <div class="container">
        <br>
        <br>
        <div class="row mt-4">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <?php foreach ($feilds as $key => $value) : ?>
                                <th> <?php echo $value->name; ?> </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <?php foreach ($row as $key => $value) : ?>
                                    <td> <?php echo $value; ?> </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">ProductName</label>
                            <input type="text" name="product" placeholder="Enter your ProdectName" class="form-control" id="product-add" />
                        </div>

                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category" id="category-id-add" class="form-select">
                                <option value="">select your category</option>
                                <?php
                                $sql = "SELECT cat_id , cat_name from categery";
                                $result = mysqli_query($connection, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?php echo $row['cat_id'] ?>"> <?php echo $row['cat_name'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="text" placeholder="Enter your Quantity" name="Quantity" class="form-control" id="quantity-add" />
                        </div>

                        <div class="form-group">
                            <label for="">NetPrice</label>
                            <input type="text" placeholder="Enter your NetPrice" name="netPrice" class="form-control" id="NetPrice-add" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            <button type="submit" name="save" class="btn btn-primary"> Add product </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['save'])) {
        $product = mysqli_real_escape_string($connection, $_POST['product']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $quentity = mysqli_real_escape_string($connection, $_POST['Quantity']);
        $netPrice = mysqli_real_escape_string($connection, $_POST['netPrice']);

        $insert = "INSERT INTO prodect VALUES(null,'$product','$category','$quentity','$netPrice')";
        $result = mysqli_query($connection, $insert);
        if ($result) {
            echo  "<script> alert('insert seccess!') </script>";
        } else {
            echo "<script> alert('you have not inserted') </script>";
        }
    }
    ?>
    <script src="./Scripts/Jquery.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>


</body>

</html>