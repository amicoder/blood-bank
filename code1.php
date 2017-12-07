<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> FOOD DETAILS</title>
</head>
<body>
 
 <form name="reg1"  method="post">

  <table width="274" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td colspan="2">
        <div align="center">
          <?php 
          // $remarks=$_GET['remarks'];
          if (!isset($_GET['remarks']))
          {
            echo 'Register Here';
          }
          if (isset($_GET['remarks']) && $_GET['remarks']=='success')
          {
            echo 'Registration Success';
          }
          ?>  
        </div></td>
      </tr>
      <tr>
        <td width="95"><div align="right"> Quantity:</div></td>
        <td width="171"><input type="text" name="quantity" /></td>
      </tr>
       <tr>
        <td width="95"><div align="right"> Time of food preparation(hh:mm:ss) :</div></td>
        <td width="171"><input type="text" name="time_prep" /></td>
      </tr>
      <tr>
        <td><div align="right">Date of food preparation(yyyy-mm-dd):</div></td>
        <td><input type="text" name="date_prep" /></td>
      </tr>
      <tr>
        <td><div align="right">Venue of food collection:</div></td>
        <td><input type="text" name="loc_name" /></td>
      </tr>
       <tr>
        <td><div align="right">username:</div></td>
        <td><input type="text" name="username" /></td>
      </tr>
     
      <tr>
        <td><div align="right"></div></td>
        <td><input name="submit" type="submit" value="Submit" /></td>
      </tr>
    </table>
  </form>

<?php
  if(isset($_POST['submit'])){
 
    $db = new mysqli("localhost","root","","foodproj");
    $u= $_POST['username'];
    //echo $u;
 
  // $q1= "SELECT cid FROM cust WHERE username='".$_POST['username']."' ";
    $q1= "SELECT cid FROM cust WHERE username=$u";
    echo $q1;
    //$res=$db->query($q1);
    //echo $res;
    // create query
    $query = "INSERT INTO food(cid,quantity,time_prep,date_prep,loc_name)VALUES('$q1,'".$_POST['quantity']."','".$_POST['time_prep']."','".$_POST['date_prep']."','".$_POST['loc_name']."')"; 
    
    $result=$db->query($query);
    // execute query
    //$sql = $db->query($query);
    // num_rows will count the affected rows base on your sql query. so $n will return a number base on your query
    //$n = $result->num_rows;
    if(!empty($result)) {
    // if $n is > 0 it mean their is an existing record that match base on your query above 
    //if($n > 0){
 
      echo "\n \nINSERTED TUPLE";
    } else {
 
      echo "\n \n not suucessfull";
    }
  }

?>


</body>
</html>