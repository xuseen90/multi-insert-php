<?php include('connection.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders insert</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="">Customer</label>
                    <select name="category" id="customerDrobdown" class="form-select ml-4">
                        <option value="0">select your Customer</option>
                        <?php
                        $sql = "SELECT cus_id , name from customer";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <option value="<?php echo $row['cus_id'] ?>"> <?php echo $row['name'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- order deteles -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prodect</th>
                            <th>Quentity</th>
                            <th>NetPRice</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group m-2">
                                    <select name="category" id="ProdectDrobdown" class="form-select">
                                        <option value="0" selected>select your Prodect</option>
                                        <?php
                                        $sql = "SELECT p_id , pro_name from prodect";
                                        $result = mysqli_query($connection, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row['p_id'] ?>"> <?php echo $row['pro_name'] ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="number" id="quentity" name="name" class="form-control m-2">
                            </td>
                            <td>
                                <input type="number" id="price" name="price" class="form-control m-2" readonly>
                            </td>
                            <td>
                                <input type="number" id="balance" name="balance" class="form-control m-2" readonly>
                            </td>
                            <td>
                                <button type="button" name="add" id="add" class="btn btn-success m-2">Add</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>prodectName</th>
                            <th>Quentity</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody id="orderTbody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="">Total</label>
                    <input type="number" id="total" readonly class="form-control">
                </div>
                <div class="py-2">
                    <button type="button" name="save" id="save" class="btn btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./Scripts/Jquery.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ProdectDrobdown').on('change', function() {
                var id = $(this).val();
                if ($(this).val() != 0) {
                    $.post('getProdectPrice.php', {
                        id: $(this).val()
                    }, function(res) {
                        var res1 = res.split(",");
                        $('#price').val($.trim(res1[0]));
                        $("#quentity").val(1)
                        calculate()
                    })
                } else {
                    reset()
                }
            })
            //  resut
            function reset() {
                $('#price').val('')
                $('#quentity').val('')
                $('#balance').val('')
                $('#ProdectDrobdown').val(0);
            }
            //  calcualte
            function calculate() {
                var price = $("#price").val()
                var quantity = $("#quentity").val()
                var subTotal = price * quantity
                $("#balance").val(subTotal)
            }
            // quantity change calcualte
            $("#quentity").change(function() {
                if ($('#quentity').val() > 0) {
                    calculate()
                }
            })
            //  add
            $('#add').on('click', function() {
                var isValid = true
                if ($('#ProdectDrobdown').val() == 0) {
                    isValid = false
                    console.log('Please select product')
                }
                // vars 
                var ProductId = $('#ProdectDrobdown').val()
                var productName = $("#ProdectDrobdown option:selected").text()
                var quentity = $('#quentity').val()
                var subTotal = $('#balance').val()

                var orderTbody = $('#orderTbody')
                // td 

                var productTd = "<td class='product-td' product-id='" + ProductId + "'>" + productName + "</td>";

                var quantityTd = "<td class='quantity-td'>" + quentity + "</td>"
                var subTotalTd = "<td class='sub-total-td' sub-total='" + subTotal + "'>$" + subTotal + "</td>"
                var removeBtnTd = "<td><button class='btn btn-danger remove' id='removebtn'>Remove</button></td>"
                // tr
                var tr = "<tr class='order-details-tr'>" + productTd + quantityTd + subTotalTd + removeBtnTd + "</tr>";
                orderTbody.append(tr)
                reset()
                calculateTotal()
            })

            // calculate total
            function calculateTotal() {
                var total = 0;
                $('.sub-total-td').each(function() {
                    var subTotal = $(this).attr('sub-total')
                    total += parseFloat(subTotal)
                })
                $('#total').val(total)
            }
            // calculate Subtotal
            function calcualteSubTotal() {
                var total = 0;
                $('.sub-total-td').each(function() {
                    var subTotal = $(this).attr('sub-total')
                    total -= -(parseFloat(subTotal))
                })
                $('#total').val(total)
            }
            // remove button 
            $(document).on('click', '#removebtn', function() {
                $(this).closest("tr").remove();
                calcualteSubTotal()
            });
            // save data
            $('#save').click(function() {
                var isValid = true
                var orderDetailCount = $('#orderTbody tr').length;
                if (orderDetailCount == 0) {
                    isValid = false
                    console.log("isEmpty");
                }
                if ($('#customerDrobdown').val() == 0) {
                    isValid = false
                    console.log("customer empty")
                }
                if (isValid) {
                    var customerId = $('#customerDrobdown').val()
                    var total = $('#total').val()
                    var orderCustomer = {
                        Customer_id: customerId,
                        Total: total
                    }


                    var orderDetails = []
                    $('#orderTbody tr').each(function() {
                        var tr = $(this)
                        var productId = tr.children('.product-td').attr('product-id')
                        var quantity = tr.children('.quantity-td').text()
                        var subTotal = tr.children('.sub-total-td').attr('sub-total')
                        var orderObject = {
                            ProductId: productId,
                            Quantity: quantity,
                            SubTotal: subTotal
                        }
                        // adding array
                        orderDetails.push(orderObject)
                    })
                    // sending the date by using ajax 
                    $.ajax({
                        url: 'sendOrder.php',
                        method: 'POST',
                        data: {
                            OrderCustomer: orderCustomer,
                            OrderDetails: orderDetails
                        },
                        success: function(res) {
                            var Data = JSON.parse(res)
                            if (Data.success) {
                                console.log(Data.message)
                            } else {
                                console.log(Data.message)
                            }
                        }
                    })

                }
            })



        })
    </script>


</body>

</html>