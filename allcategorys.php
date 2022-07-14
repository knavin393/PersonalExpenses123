<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include_once 'master_functions.php';
require "dbconfigs/config.php";

$db = new Config();
$conn = $db->getConnection();

$error = "";
$result = "";
$id = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);
if (!empty($id)) {
    try {
        $sqlQuery = "delete from expensecategory where  id=:id";
        $stmt = $conn->prepare($sqlQuery);
        $row = $stmt->execute(array(":id" => $id));
        if ($row2) {
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
    <title>Categorys</title>

    <?php require "importcss.php" ?>

    <style>
        .table>thead>tr {
            background: url(../../../images/sort_row_bg.gif) 0 50% repeat-x;
        }
    </style>
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
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <h3><label><i class="fa fa-cog" aria-hidden="true"></i> Categories</label></h3>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <a class="btn " href="addcategory.php" style="background: linear-gradient(45deg , #47cebe ,#ef4a82);
color: white;height: 40px;">Add Category                                               </a>

                                            </div>
                                        </div>
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

                                                <thead>
                                                    <tr>

                                                        <th>Name</th>
                                                        <th>Edit </th>
                                                        <th>Delete </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    try {
                                                        $sqlQuery = "select * from expensecategory";
                                                        $stmt = $conn->prepare($sqlQuery);
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch()) {

                                                    ?>
                                                            <tr>
                                                                <td><?= $row["name"] ?></td>
                                                                <td>
                                                                    <a class="btn btn-info btn-sm" href="addcategory.php?id=<?= $row['id'] ?>"><i class="fas fa-edit"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-danger btn-sm" href="allcategorys.php?id=<?= $row['id'] ?>"><i class="fas fa-trash"></i></a>
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
                                        <hr>

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


    <!-- (Ajax Modal)-->
    <div class="modal fade" id="page_model_view_data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
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