
<?php
error_reporting(0);

 $fromdate=$_POST['from_date'];
  $todate=$_POST['to_date'];
  ?>
<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include_once 'master_functions.php';
require "dbconfigs/config.php";

$db = new Config();
$conn = $db->getConnection();

$expamount=0;
$totalbudget=0;
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
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

 <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
        <?PHP
       if (empty($fromdate && $todate)) {
           $sqlQuery = "SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id GROUP BY categoryid";

               }else{
                         $sqlQuery="SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id  AND exp.date_incurred between '$fromdate' AND '$todate' GROUP BY categoryid";

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
        ]);

        var options = {
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }


    </script>


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
                                        <h3><label><i class="fa fa-database" aria-hidden="true"></i>Expenses Chart</label></h3>
                                        </div>
                                        <hr>
                                     <form method="POST" style="width: 100%">
     <?php
if (empty($fromdate)) {

?>
      <input type="date" name="from_date" style="border: 1px solid black;width: 200px;margin-left: 10px;">

<?php
}else{

?>
      <input type="date" name="from_date" style="border: 1px solid black;width: 200px;margin-left: 10px;" value="<?php echo $fromdate ?>">

<?php
}
?>


<?php
if (empty($todate)) {

?>
            <input type="date" name="to_date" style="border: 1px solid black;width: 200px;margin-left: 10px;">

<?php
}else{

?>
            <input type="date" name="to_date" style="border: 1px solid black;width: 200px;margin-left: 10px;" value="<?php echo $todate ?>">

<?php
}
?>



<button type="submit" name="filter" class="btn" style="background: linear-gradient(45deg,#47cebe,#ef4a82);color: white;width: 120px;margin-left: 10px;
">Filter</button>


    </form>

 

    
    <div style="width: 900px;height: 560px;">
              <div id="piechart_3d" style="width: 100%;height: 100%;" > </div>


    </div>

<div style="margin-top:0px;">
 <table id="example1" class="table  table-bordered dt-responsive nowrap" style="width:100%">

   
                                       
                                            <thead>
                                                <tr>
                                                 
                                                    <td class="th1">Date</td>
                                                    <td class="th1">Total Expenses</td>
                                                     <td class="th1">Total Budget</td>
                                                      <td class="th1">Available Money</td>
                                                     
                                                     <td class="th1">Status</td>
                                                
                                                   
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                             
                                                        <tr>
                                                          

                                                       <td class="th2"><?php echo "(". ($fromdate). ")" . " - " . "(" .($todate) . ")" ?></td>
                                                          
                                                            <td class="th2">RM&nbsp;<?php echo $expamount ?></td>
                                                          
                                                            <td class="th2">RM&nbsp;<?php echo $totalbudget ?></td>
                                                             <td class="th2">RM&nbsp;<?=$sum_total= $totalbudget-$expamount ?></td>
                                                            
                                                            

                                                            <td class="th2">
                                                              <?php if ($expamount>$totalbudget) {

      # code...
     ?>
    <button class='btn bg-blue-grey waves-effect' style="background:red; text-transform: uppercase;font-size: 1em;
letter-spacing: 1px; color: white;" type="">
       <span>Greater than budget</span>
     </button>
     <?php
}else if($expamount<$totalbudget){


     ?>
      <button class='btn bg-blue-grey waves-effect' style="background:green;  text-transform: uppercase;font-size: 1em;
letter-spacing: 1px; color: white;" type="">
       <span>Less than budget</span>
     </button>
     <?php
}else if($expamount==$totalbudget){


     ?>
       <button class='btn bg-blue-grey waves-effect' style="background:yellow; text-transform: uppercase; font-size: 1em;
letter-spacing: 1px; color: black;" type="">
       <span>Equal to Budget </span>
   </button>
     <?php
}
     ?>
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
  </div>


   <style>
        .table-bordered{
          
          text-align: center;
         border-collapse: collapse;

        
   }
 .th1{
  background:   #A52A2A;
  color: white;
  border-spacing: 0;
  text-transform: uppercase;
   font-size: 1em;
 letter-spacing: 1px;
 font-style: bold;

 }
 .th2{
  color: black;
  font-size: 1em;
  text-transform: uppercase;
  letter-spacing: 1px;
 
 }


  tr:hover{
background:     #CD5C5C;
inset:-3px;
transition: 0.5s;
}



      </style>

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