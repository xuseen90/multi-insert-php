<?php
include('connection.php');
if (isset($_POST['id'])) {
    $query = mysqli_query($connection, "SELECT Price from prodect where p_id= $_POST[id]");
    $reselt = mysqli_fetch_assoc($query);
    echo implode(",", $reselt);
}
