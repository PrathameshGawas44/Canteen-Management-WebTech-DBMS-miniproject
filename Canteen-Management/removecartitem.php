<html>
<body>
<?php
    $Id = htmlspecialchars($_GET['id']);
    $i = htmlspecialchars($_GET['i']);
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="delete from cart where C_id='$Id' and Item_id='$i'";
        $r1=mysqli_query($c,$q1);
        if($r1)
        {
            if(mysqli_query($c,"select * from cart where C_id='$C' and Item_count=0"))
            {
                $q2="delete from cart where C_id='$C' and Item_count=0";
                mysqli_query($c,$q2);
            }
        }
        if($r1)
            header("Location: home.php?id=$Id&show=cart");
        else
            echo "<script>alert('Error');window.history.back();</script>";
?>
</body>
</html>