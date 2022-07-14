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

$name = filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW);


$error = "";
$result = "";
//*****************Add category*****************************
if ($controlid == "addnew") {
    try {
        $sqlQuery = "insert into expensecategory(name)
                 values (:name)";

        $stmt = $conn->prepare($sqlQuery);
        $row2 = $stmt->execute(
            array(
                ":name" => $name
            )
        );

        if ($row2) {
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


//*****************Edit category*****************************
if ($controlid == "edit") {
    try {
        $sqlQuery = "update  expensecategory set name=:name where id=:id ";

        $stmt = $conn->prepare($sqlQuery);

        $row2 = $stmt->execute(
            array(
                ":name" => $name,  ":id" => $id
            )
        );

        if ($row2) {
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
        $sqlQuery = "select * from expensecategory where id=$id";
        $stmt = $conn->prepare($sqlQuery);

        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $name = $row['name'];
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
    <title>Add Category</title>

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
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="card-title">
                                            <h3 class="text-center title-2">Add Category</h3>
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
                                        <form class="form-control" id="categoryform" method="post">

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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-1">Category Name</label>
                                                        <input id="" name="name" type="text" class="form-control input-sm form-control-sm " value="<?= (!empty($id)) ? $name : "" ?>" data-val="true" placeholder="" autocomplete="off" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <br>
                                                    <button style="width:150px;" type="submit" class="btn btn-sm btn-success saveBtn btn-block">
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
    </script>
</body>

</html>
<!-- end document-->