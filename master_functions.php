<?php


function roundOff2dp($amount)
{
    return round($amount);
}

function moneyFormat2dp($amount)
{
    return "" . number_format($amount, 2);
}
  

function checkStatus($value)
{

    $message = "";
    if ($value == "g") {
?>

 <button class='btn bg-blue-grey waves-effect'  style="background:red; 
letter-spacing: 1px; color: white;" type="">
 <span><?= $message="Greater Than Budget"?></span>

 <?php
        

    } elseif ($value == "e") {
        ?>
         <button class='btn bg-blue-grey waves-effect'  style="background:yellow;  
letter-spacing: 1px; color: black;" type="">
         <span><?= $message="Equal To Budget"?></span>
       <?php
    } else {
        ?>
         <button class='btn bg-blue-grey waves-effect'  style="background:green;
letter-spacing: 1px; color: white;" type="">
          <span><?= $message="Less Than Budget"?></span>
          <?php
      
    }
   

}
?>

<style>


   .table-bordered{
          
          text-align: center;
         border-collapse: collapse;

        
   }

</style>

<?php




function formatNormalDate($date)
{

    return date("d M, Y", strtotime($date));
}

function getDateToday()
{
    return date("Y-m-d");
}

function getDateTimeTodayToAMPM()
{

    $today = date('Y-m-d h:i:s', time());
    return $today;
}

function getStartDate()
{

    $days = 180;
   
    $start_date = date('Y-m-d', strtotime('-' . $days . ' days'));
    return $start_date;
}
