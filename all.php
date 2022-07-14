<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include_once 'master_functions.php';
require "dbconfigs/config.php";

$db = new Config();
$conn = $db->getConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);
$error = "";
$result = "";
if (!empty($id)) {
    try {
        $sqlQuery = "delete from expenses where  id=:id";
        $stmt = $conn->prepare($sqlQuery);
        $row = $stmt->execute(array(":id" => $id));
        if ($row) {
            $result = "1";
        } else {
            $result = "2";
            $error = "Delete Failed";
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
                                        <h3><label><i class="fa fa-database" aria-hidden="true"></i> All Expenses </label></h3>
                                        </div>
                                        <hr>
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Category</th>
                                                    <th>Budget</th>
                                                    <th>Amount</th>
                                                      <th>Available Money</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                try {
                                                    $sqlQuery = "select expenses.id, expenses.budget, expenses.date_incurred, expenses.categoryid, expenses.expenseamount, expenses.status, expensecategory.name category from expenses left join expensecategory on expensecategory.id=expenses.categoryid";
                                                    $stmt = $conn->prepare($sqlQuery);
                                                    $stmt->execute();
                                                    while ($row = $stmt->fetch()) {

                                                ?>
                                                        <tr>
                                                            <td><?= $row["date_incurred"] ?></td>
                                                            <td><?= $row["category"] ?></td>
                                                            <td>RM&nbsp;<?= $row["budget"] ?></td>
                                                            <td>RM&nbsp;<?= $row["expenseamount"] ?></td>
                                                              <td>RM&nbsp;<?=$sum_total= $row["budget"]-$row["expenseamount"] ?></td>
                                                            <td ><?= checkStatus($row['status']); ?></td>
                                                            <td>
                                                                <a class="btn btn-info btn-sm" href="home.php?id=<?= $row['id'] ?>"><i class="fas fa-edit"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="all.php?id=<?= $row['id'] ?>"><i class="fas fa-trash"></i></a>
                                                            </td>

                                                        </tr>
                                                <?php
                                                    }
                                                } catch (Exception $exc) {
                                                    $message = "Unexpected Error Occured";
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
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
    <?php require "importjs.php" ?>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#example').DataTable();

        });
    </script>
</body>

</html>
<!-- end document-->