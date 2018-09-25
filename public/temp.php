<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "hello world"; 


$servername = "mysql.nelsonwaldorf.org";
$username = "nwsgrocerycards";
$password = "Iwtws2buycards!";
$dbname = "nelsonwaldorf_grocerycards";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, name, email,payment,saveon,coop, schedule, deliverymethod FROM users WHERE 1 AND schedule='monthly-second' ";
//$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //$sql="INSERT INTO `orders_sep20` (`id`, `user_id`, `cutoff_date_id`, `paid`, `payment`, `saveon`, `coop`, `deliverymethod`, `created_at`, `updated_at`, `pac`, `tuitionreduction`, `profit`, `marigold`, `daisy`, `sunflower`, `bluebell`, `class_1`, `class_2`, `class_3`, `class_4`, `class_5`, `class_6`, `class_7`, `class_8`, `referrer`, `coop_onetime`, `saveon_onetime`)";
        //$sql.="VALUES (NULL, '".$row["id"]."', '83', '0', '".$row["payment"]."', '".$row["saveon"]."', '".$row["coop"]."', '".$row["deliverymethod"]."', '2018-09-19 07:05:21', '2018-09-19 07:05:21', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', NULL, NULL);";
        //$resultinsert =$conn->query($sql);
        //echo $sql."<br><br>";
        
        //get order id by cutoff 83 and user id $row["id"]
        //select from classes_users all user classes
        //insert into classes_orders_sep20 order_id, class_id, profit =0

        $sql = "SELECT id FROM orders_sep20 WHERE 1 AND cutoff_date_id=83 AND user_id=".$row["id"]." ";
        $orderResult = $conn->query($sql);
        $orderRow=$orderResult->fetch_assoc();
        //echo "user id=".$row["id"]." Order id=".$orderRow["id"]."<br>";
        //echo $orderRow["id"].",";
        
        $sql = "SELECT class_id FROM classes_users WHERE 1 AND user_id=".$row["id"]." ";
        $classidsResult = $conn->query($sql);
        while($classidRow = $classidsResult->fetch_assoc()) {
            //echo "user id=".$row["id"]." Class id=".$classidRow["class_id"]."<br>";
            
            $sql="INSERT INTO `classes_orders_sep20` (`id`, `order_id`, `class_id`, `profit`) VALUES (NULL,'".$orderRow["id"]."','".$classidRow["class_id"]."','0.00');";
            //echo $sql."<br>";
            //$conn->query($sql);
        }
        
        
    }
} else {
    echo "0 results";
}
$conn->close();



/*
 *         //$sql1="SELECT id, coop_onetime, saveon_onetime FROM orders_back1 WHERE 1 AND user_id='".$row["id"]."' AND cutoff_date_id=81";
        //$result1 = $conn->query($sql1);
        //$row1["id"]=0;
        //$row1["coop_onetime"]=0;
        //$row1["saveon_onetime"]=0;
        //if ($result1->num_rows > 0)
           //$row1 = $result1->fetch_assoc();
        
        //echo "id: " . $row["id"]. " - email: " . $row["email"]. " " . $row["schedule"]. " " . $row1["coop_onetime"]. " ". $row1["saveon_onetime"]. " ". $row1["id"]."<br>";
        
        if ($row["schedule"]=="none" && $row1["id"]!=0 && $row1["coop_onetime"]==0 && $row1["saveon_onetime"]==0)
        {
            //echo $row["name"]. "," . $row["email"]."<br>";

            $sqlDelOrders="DELETE FROM orders WHERE 1 AND id='".$row1["id"]."'";
            //echo $sqlDelOrders."<br>";
            
            $sqlDelProfit="DELETE FROM classes_orders WHERE 1 AND order_id='".$row1["id"]."'";
            //echo $sqlDelProfit."<br>";
            
            //$result33 = $conn->query($sqlDelOrders);
            //$result44 = $conn->query($sqlDelProfit);
        }
        

 */
?>