<html>
    <head>
        <title>Remove item</title>
    </head>
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
            $q1="delete from menu where Item_id='$Id'";
            $r1=mysqli_query($c,$q1);
            if($r1)
                echo "<script>alert('Item Removed successfully'); window.location.href = 'delete.php?id={$C}';</script>";
            else
                echo "<script>alert('Failed to Remove item'); window.history.back();</script>";
            mysqli_close($c);
        ?>
    </body>
</html>