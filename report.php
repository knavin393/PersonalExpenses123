<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require "dbconfigs/config.php";
include_once 'master_functions.php';

$db = new Config();
$conn = $db->getConnection();

$expamount=0;
$totalbudget=0;
$start_date = "";
$stop_date = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = filter_input(INPUT_POST, 'start_date', FILTER_UNSAFE_RAW);
    $stop_date = filter_input(INPUT_POST, 'stop_date', FILTER_UNSAFE_RAW);
}
if (empty($start_date) || empty($stop_date)) {
    $start_date = getStartDate();
    $stop_date = getDateToday();
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Title Page-->
    <title>Report</title>


 <script type="text/javascript">
      
        <?PHP
       if (empty($start_date && $stop_date)) {
           $sqlQuery = "SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id GROUP BY categoryid";

               }else{
                         $sqlQuery="SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id  AND exp.date_incurred between '$start_date' AND '$stop_date' GROUP BY categoryid";

               }
                                                    $stmt = $conn->prepare($sqlQuery);
                                                     $stmt->execute();

                                                    while ($row = $stmt->fetch()) {
           # code...
          $expamount+=$row['sum_exp'];
          $totalbudget+=$row['sum_budget'];

          echo "['".$row['name']."',".$row['expenseamount']."],";
         }
         ?>
        

        

       
      


    </script>






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
                                <div class="card  ">
                                    <div class="card-body">



                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <h3><label><i class="fa fa-pie-chart" aria-hidden="true"></i> Expenses Report</label></h3>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <form action="report.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                     


                                                                <label class="control-label mb-1">From :</label>
                                                                <input id="" name="start_date" type="date" value="<?php echo $start_date; ?>" class="form-control input-sm form-control-sm datepicker" data-val="true" placeholder="" autocomplete="off" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label mb-1">To: </label>
                                                                <input id="" name="stop_date" type="date" value="<?php echo $stop_date; ?>" class="form-control input-sm form-control-sm datepicker" data-val="true" placeholder="" autocomplete="off" required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" align="left">
                                                            <br />


                                                            <button class='btn bg-blue-grey waves-effect' type="submit">
                                                            
                                                                <i class='fa fa-search'></i> Filter
                                                                </button>
                                                   
                                                        <a href="user_data_print.php?start_date=<?php echo $start_date; ?>&stop_date=<?php echo $stop_date; ?>" target="_blank" class='btn bg-blue-grey waves-effect' style="background: linear-gradient(45deg , #47cebe ,#ef4a82);color: white;width: 90px; margin-top: -60px;margin-left: 100px;">Print</a>
                                                        
                                                        </div>
                                                    </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <br>
                                        <table id="example" class="table table-striped table-bordered  dt-responsive nowrap" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Category</th>
                                                    <th>Budget</th>
                                                    <th>Amount</th>
                                                      <th>Available Money</th>
                                                    <th>Status</th>

                                                
                                                    
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                try {
                                                    $where = " where (DATE(date_incurred) between '$start_date' and '$stop_date')   ";
                                                    $sqlQuery = "select expenses.id, expenses.budget, expenses.date_incurred, expenses.categoryid, expenses.expenseamount, expenses.status, expensecategory.name category from expenses left join expensecategory on expensecategory.id=expenses.categoryid $where";

                                                    $stmt = $conn->prepare($sqlQuery);
                                                    $stmt->execute();
                                                    while ($row = $stmt->fetch()) {
                                                ?>
                                                        <tr>
                                                            <td><?= $row["date_incurred"] ?></td>
                                                            <td><?= $row["category"] ?></td>
                                                            <td>RM<?= $row["budget"] ?></td>
                                                            <td>RM<?= $row["expenseamount"] ?></td>
                                                            <td>RM&nbsp;<?=$sum_total= $row["budget"]-$row["expenseamount"] ?></td>
                                                            <td><?= checkStatus($row['status']); ?></td>


                                                    </tr>
                                                     
                                                <?php
                                                    }
                                                } catch (Exception $exc) {
                                                    $message = "Unexpected Error Occured";
                                                }
                                                ?>
                                            <tr>

                                                    <th style="text-align: center;font-size: 1em;text-transform: uppercase;">Total Spent</th>

                                                    <td style="text-align: center;font-size: 1.3em; background-color:#C0C0C0;color: black;">RM<?= $expamount ?></td>
                                                </tr>
                                                <tr>

                                                    <th style="text-align: center;font-size: 1em;text-transform: uppercase;">Total Budget</th>
                                                     <td style="text-align: center;font-size: 1.3em;background-color:#C0C0C0;color: black;">RM<?= $totalbudget ?></td>
                                                 </tr>
                                                   <tr>

                                                    <th style="text-align: center;font-size: 1em;text-transform: uppercase;">Total Available Money</th>
                                                     <td style="text-align: center;font-size: 1.3em;background-color:#C0C0C0;color: black;">RM&nbsp;<?=$sum_total= $totalbudget - $expamount ?></td>
                                                 </tr>
                                                 <tr>

                                                    <th style="text-align: center;font-size: 1em;text-transform: uppercase;">Overall Status</th>
                                          <td>
                                            <?php if($expamount<$totalbudget){ ?>
                                                 <button class='btn bg-blue-grey waves-effect' style="background:green;  text-transform: uppercase;font-size: 1em;
letter-spacing: 1px; color: white;" type="">

                                        <span style="text-align: center;">
                                            Spent is Less Than Budget.
                                         </span></button>
                                        <?php } elseif($expamount>$totalbudget) { ?>
                                            <button class='btn bg-blue-grey waves-effect' style="background:red; text-transform: uppercase;font-size: 1em;
letter-spacing: 1px; color: white;" type="">
                                        <span style="text-align: center; ">
                                            Spent is Greater Than Budget.
                                         </span></button>
                                        <?php } else { ?>
                                            <button class='btn bg-blue-grey waves-effect' style="background:yellow; text-transform: uppercase; font-size: 1em;
letter-spacing: 1px; color: black;" type="">
                                        <span style="text-align: center; ">
                                            Spent is Equal To Budget.
                                        </span></button>
                                         <?php } ?>
                                     </td>

                                     </tr>

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

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-3d'
            })
        });
    </script>
</body>


<script src="jsprint/jquery-3.2.1.min.js"></script>
<script src="jsprint/bootstrap.js"></script>
</html>
<!-- end document-->