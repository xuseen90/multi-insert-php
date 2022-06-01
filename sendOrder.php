<?php
include("connection.php");
if (isset($_POST['OrderCustomer'])) {
    // Converting Data
    $sent = json_encode($_POST['OrderCustomer']);
    $OrderCustomer = json_decode($sent, true);


    $sent = json_encode($_POST['OrderDetails']);
    $OrderDetails = json_decode($sent, true);

    $customerId = $OrderCustomer['Customer_id'];
    $total = $OrderCustomer['Total'];

    $query = "INSERT INTO `orders`(`or_id`, `cust_id`, `Total`)  VALUES (NULL, '$customerId', '$total')";
    $stmt = mysqli_query($connection, $query);
    if ($stmt) {
        $orderId = mysqli_insert_id($connection);

        foreach ($OrderDetails as $orderDetail) {

            $prodectId = $orderDetail['ProductId'];
            $quantity = $orderDetail['Quantity'];
            $subTotal = $orderDetail['SubTotal'];

            $query = "INSERT INTO `order_detelis`(`order_id`, `or_id`, `pro_id`, `quentity`, `subTotal`) 
            VALUES (NULL , '$orderId', '$prodectId','$quantity','$subTotal')";
            $stmt = mysqli_query($connection, $query);
        }
        $data = array("success" => true, "message" => "Saved Successfully");
        echo json_encode($data);
    }
}
