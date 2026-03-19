<html>
    <head>
        <title>Add item</title>
    </head>
    <body>
        <?php
            $c=mysqli_connect("localhost","root","","cmanagement");
            if(!$c)
            {
                echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
                exit();
            }
            $item=$_POST['item'];
            $img=$_POST['ico'];
            $price=$_POST['pri'];
            $q1="insert into menu (Item_name,Item_img,Item_amt) values('$item','$img','$price')";
            $r1=mysqli_query($c,$q1);
            if($r1)
                echo "<script>alert('Item Added successfully'); window.location.href = 'add.html';</script>";
            else
                echo "<script>alert('Failed to Add item'); window.location.href = 'Adminhome.php';</script>";
            mysqli_close($c);
        ?>
    </body>
</html>