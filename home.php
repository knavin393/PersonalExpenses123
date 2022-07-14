<!DOCTYPE html>
<html lang="en">
<?php

session_start();

include_once 'master_functions.php';
require "dbconfigs/config.php";

$db = new Config();
$conn = $db->getConnection();

$controlid = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW);
$id = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);

$budget = filter_input(INPUT_POST, 'budget', FILTER_UNSAFE_RAW);
$date_incurred = filter_input(INPUT_POST, 'date_incurred', FILTER_UNSAFE_RAW);
$categoryid = filter_input(INPUT_POST, 'categoryid', FILTER_UNSAFE_RAW);
$expenseamount = filter_input(INPUT_POST, 'expenseamount', FILTER_UNSAFE_RAW);
$status = filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW);

$error = "";
$result = "";
//*****************Add expenses*****************************
if ($controlid == "addnew") {
    try {
        $sqlQuery = "insert into expenses(budget,date_incurred,categoryid,expenseamount,status)
                 values (:budget,:date_incurred,:categoryid,:expenseamount,:status)";

        $stmt = $conn->prepare($sqlQuery);
        $row = $stmt->execute(
            array(
                ":budget" => $budget, ":date_incurred" => $date_incurred, ":categoryid" => $categoryid, ":expenseamount" => $expenseamount, ":status" => $status
            )
        );

        if ($row) {
            $result = "1";
        } else {
            $result = "2";
            $error = "Registration Failed";
        }
    } catch (Exception $exc) {
        $result = "2";
        $error = "Unexpected Error Occured ";
    }
}


//*****************Edit expenses*****************************
if ($controlid == "edit") {
    try {
        $sqlQuery = "update  expenses set budget=:budget,date_incurred=:date_incurred,categoryid=:categoryid,expenseamount=:expenseamount,status=:status where id=:id ";

        $stmt = $conn->prepare($sqlQuery);

        $row = $stmt->execute(
            array(
                ":budget" => $budget, ":date_incurred" => $date_incurred, ":categoryid" => $categoryid, ":expenseamount" => $expenseamount, ":status" => $status, ":id" => $id
            )
        );

        if ($row) {
            $result = "1";
            $error = "Update OK";
        } else {
            $result = "2";
            $error = "Update Failed";
        }
    } catch (Exception $exc) {
        $result = "2";
        $error = "Unexpected Error Occured ";
    }
}


if (!empty($id)) {
    try {
        $sqlQuery = "select * from expenses where id=$id";
        $stmt = $conn->prepare($sqlQuery);

        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $budget = $row['budget'];
            $date_incurred = $row['date_incurred'];
            $categoryid = $row['categoryid'];
            $expenseamount = $row['expenseamount'];
            $status = $row['status'];
        }
    } catch (Exception $exc) {
        $result = "2";
        $error = "Unexpected Error Occured ";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Title Page-->
    <title>Add Expenses</title>

    <?php require "importcss.php" ?>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php require "sections/header-mobile.php"; ?>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <?php require "sections/sidebar.php"; ?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php require "sections/header-top.php"; ?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">



                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        <div class="row m-t-25">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="card-title">
                                            <h3 class="text-center ">Add Expense</h3>
                                        </div>
                                        <?php
                                        if ($result == "1") {
                                        ?>
                                            <div class="alert alert-success" id="success-alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Success! </strong>Details Saved Successfully!
                                            </div>
                                        <?php
                                        } else if ($result == "2") { ?>
                                            <div class="alert alert-danger" id="success-alert">
                                                <button type="button" class="close" data-dismiss="alert">x</button>
                                                <strong>Error! </strong> <?php echo $error; ?>!
                                            </div>

                                        <?php
                                        }
                                        ?>
                                        <hr>
                                        <form class="form-control" id="expenseform" method="post">

                                            <!-- Status-->
                                            <input id="" name="action" type="hidden" value="<?php
                                                                                            if (!empty($id)) {
                                                                                                echo "edit";
                                                                                            } else {
                                                                                                echo "addnew";
                                                                                            }
                                                                                            ?>">
                                            <!-- status -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label mb-1">Date Incurred</label>
                                                        <input id="" name="date_incurred" type="text" class="form-control input-sm form-control-sm datepicker" value="<?= (!empty($id)) ? $date_incurred : "" ?>" data-val="true" placeholder="" autocomplete="off" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label mb-1">Budget</label>
                                                        <input id="budget" name="budget" min="0" onchange="getStatus();" onkeyup="getStatus();" type="number" class="form-control input-sm form-control-sm" value="<?= (!empty($id)) ? $budget : 0 ?>" data-val="true" placeholder="" autocomplete="off" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label mb-1">Category</label>
                                                        <select name="categoryid" class="form-control select2" id="categoryid" required>
                                                            <option value="">Select category</option>
                                                            <?php
                                                            $sqlQuery = "select * from expensecategory";
                                                            $stmt = $conn->prepare($sqlQuery);
                                                            $stmt->execute();
                                                            while ($row = $stmt->fetch()) {
                                                            ?>
                                                                <option value="<?= $row['id'] ?>" <?php
                                                                                                    if ($row['id'] == $categoryid) {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    ?>>
                                                                    <?= $row['name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label mb-1">Expense Amount</label>
                                                        <input id="expenseamount" min="0" onchange="getStatus();" onkeyup="getStatus();" name="expenseamount" type="number" class="form-control input-sm form-control-sm" value="<?= (!empty($id)) ? $expenseamount : 0 ?>" data-val="true" placeholder="" autocomplete="off" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <b><label class="control-label mb-1">STATUS:</label></b><br>
                                                        <span id="message" style="font:600;"><?= (!empty($id)) ? checkStatus($status) : "" ?></span>
                                                        <input type="hidden" id="status" name="status" value="<?= (!empty($id)) ? $status : "" ?>">
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-md-12 col-sm-12" align="center">
                                                    <button style="width:150px;    background: linear-gradient(45deg , #47cebe ,#ef4a82);
color: white;height: 40px;" type="submit" class="btn btn-sm  saveBtn btn-block">
                                                        <i class="fa fa-save fa-lg"></i>&nbsp;
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
    <?php require "importjs.php" ?>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-3d'
            })
        });

        function getStatus() {
            var budget = parseInt($("#budget").val());
            var amount = parseInt($("#expenseamount").val());
            var status = "";
            var message = "";
            if (budget) {

                if (amount < budget) {
                    
                    status = "l";
                    message = "Less Than Budget";
                } else if (amount == budget) {
                    status = "e";
                    message = "Equal To Budget";
                } else if (amount > budget) {
                    status = "g";
                    message = "Greater Than Budget";
                }
                $("#status").val(status);
                $("#message").text(message);
            } else {
                alert("Warning : Enter Budget first");
            }

        }
    </script>


    
</body>

</html>
<!-- end document-->