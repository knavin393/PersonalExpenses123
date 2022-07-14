


  <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
    session_start();

    require "dbconfigs/config.php";
    include_once "master_functions.php";

    $db = new Config();
    $conn = $db->getConnection();

    $expamount = 0;
    $totalbudget = 0;

    $start_date = "";
    $stop_date = "";

    function IsNullOrEmptyString($str)
    {
      return $str === null || trim($str) === "";
    }

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      $start_date = filter_input(INPUT_GET, "start_date", FILTER_UNSAFE_RAW);
      $stop_date = filter_input(INPUT_GET, "stop_date", FILTER_UNSAFE_RAW);

      if (IsNullOrEmptyString($start_date) || IsNullOrEmptyString($stop_date)) {
        $start_date = getStartDate();
        $stop_date = getDateToday();
      }
    }

    $where = " WHERE date_incurred BETWEEN '$start_date' and '$stop_date'";
    $sqlQuery = "select expenses.id, expenses.budget, expenses.date_incurred, expenses.categoryid, expenses.expenseamount, expenses.status, expensecategory.name category from expenses left join expensecategory on expensecategory.id=expenses.categoryid $where";

    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    while ($row = $stmt->fetch()) { ?>

       
   
       <tr>
       <td style="text-align:center;"><?= $row["date_incurred"] ?></td>
       <td style="text-align:center;"><?= $row["category"] ?></td>
       <td style="text-align:center;"><?= $row["budget"] ?></td>
       <td style="text-align:center;"><?= $row["expenseamount"] ?></td>
        <td>RM&nbsp;<?=$sum_total= $row["budget"]-$row["expenseamount"] ?></td>
       <td style="text-align:center;"><?= checkStatus($row["status"]) ?></td>

   
      
      </tr>
    </tbody>
     <?php }
    if (empty($start_date && $stop_date)) {
      $sqlQuery =
        "SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id GROUP BY categoryid";
    } else {
      $sqlQuery = "SELECT SUM(exp.expenseamount) as sum_exp,SUM(exp.budget) as sum_budget,exp.*,expc.* FROM expenses exp,expensecategory expc WHERE exp.categoryid=expc.id  AND exp.date_incurred between '$start_date' AND '$stop_date' GROUP BY categoryid";
    }
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
      # code...
      $expamount += $row["sum_exp"];
      $totalbudget += $row["sum_budget"];
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
                                            <?php if ($expamount < $totalbudget) { ?>
                                                 <button class='btn bg-blue-grey waves-effect' style="background:green;  text-transform: uppercase;font-size: 1em;
letter-spacing: 1px; color: white;" type="">

                                        <span style="text-align: center;">
                                            Spent is Less Than Budget.
                                         </span></button>
                                        <?php } elseif ($expamount > $totalbudget) { ?>
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


    <style> 
    .table {
      width: 100%;
      margin-bottom: 20px;

    } 

    th {
  border-bottom: 2px solid #ccc;
  font-weight: bold;
}
  
td { 
  border-bottom: 1px solid #ddd; 
}
 


/* Use this if you use span-x classes on th/td. */
table .last { padding-right: 0; 
} 

h2{
  text-align: center;
  margin-top:30px;
}


    
    .table-striped tbody > tr:nth-child(odd) > td,
    .table-striped tbody > tr:nth-child(odd) > th {
      background-color: #f9f9f9;
    }
    
    @media print{
      #print {
        display:none;
      }
    }
    @media print {
      #PrintButton {
        display: none;
      }
    }
    
    @page {
      size: auto;   /* auto is the initial value */
      margin: 0;  /* this affects the margin in the printer settings */
    }


  </style>
  </head>
<body>

  <h2>Personal Expenses System</h2>
  <br /> <br /> <br /> <br />
  <b style="color:blue;">Date Prepared:</b>
  <?php
  $date = date("Y-m-d", strtotime("+6 HOURS"));
  echo $date;
  ?>
  <br /><br />


  </table>

  <center><button id="PrintButton" onclick="PrintPage()">Print</button></center>
   




</body>
<script type="text/javascript">
  function PrintPage() {
    window.print();
  }
  document.loaded = function(){
    
  }
  window.addEventListener('DOMContentLoaded', (event) => {
      PrintPage()
    setTimeout(function(){ window.close() },750)
  });
</script>

</html>
















     





























