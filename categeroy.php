<?php include("connection.php")  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Insert</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>


    <?php
    $sql = "SELECT * FROM categery";
    $result = mysqli_query($connection, $sql);
    $fields = $result->fetch_fields();
    ?>
    <div class="container">
        <br>
        <br>
        <div class="row justify-content-center mt-4">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <?php foreach ($fields as $key => $value) : ?>
                                <th><?php echo $value->name ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <?php foreach ($row as $key => $value) : ?>
                                    <td> <?php echo $value ?> </td>
                                <?php endforeach ?>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <script src="./Scripts/Jquery.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>

</html>