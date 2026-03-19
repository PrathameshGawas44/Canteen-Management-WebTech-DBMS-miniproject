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
        $q2="select * from cart where Item_id='$Id' and C_id='$C'";
        $r2=mysqli_query($c,$q2);
        if(mysqli_num_rows($r2)==0)
        {
        $q1="insert into cart(Cart_id,C_id,Item_count,Item_id) values('$C','$C','1','$Id')";
        $r1=mysqli_query($c,$q1);
        if($r1)
            echo "<script>alert('Item Added to Cart successfully'); window.location.href = 'home.php?id={$C}';</script>";
        else
            echo "<script>alert('Failed to Add Item'); window.history.back();</script>";
        }
        else
        {
        $q1="update cart set Item_count=(Item_count+1) where C_id='$C' and Item_id='$Id'";
        $r1=mysqli_query($c,$q1);
        if($r1)
            echo "<script>alert('Item Already in Cart. Item count increased'); window.location.href = 'home.php?id={$C}';</script>";
        else
            echo "<script>alert('Error');window.history.back();</script>";
        }
?>
</html>