<html>
<body>
<?php
    $Id = htmlspecialchars($_GET['id']);
    $C = htmlspecialchars($_GET['c']);
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="delete from orders where Order_no='$Id' and Cart_id='$C'";
        $r1=mysqli_query($c,$q1);
        if($r1)
            echo "<script>alert('Order Removed Successfully');window.location.href='home.php?id={$C}';</script>";
        else
            echo "<script>alert('Error');window.history.back();</script>";
?>
</body>
</html>