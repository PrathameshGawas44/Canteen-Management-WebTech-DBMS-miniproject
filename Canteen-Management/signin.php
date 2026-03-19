<html>
<head>
    <title>signin</title>
</head>
    <body>
    <?php
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $email=$_POST["em"];
        $password=$_POST["ps"];
        $q1="select * from customer where Email='$email' and Password='$password'";
        $q2="select * from admin where Email='$email' and Password='$password'";
        $r1=mysqli_query($c,$q1);
        $r2=mysqli_query($c,$q2);
        if($r1 && mysqli_num_rows($r1)==1)
        {
            $info=mysqli_fetch_array($r1);
            echo "<script>var id='".$info['C_id'] ."';
            alert('Welcome Back'); window.location.href = 'home.php?id='+id;</script>";
        }
        else if($r2 && mysqli_num_rows($r2)==1)
        {
            $info=mysqli_fetch_array($r2);
            echo "<script>var id='".$info['A_id'] ."'; 
            alert('Welcome Back'); window.location.href = 'Adminhome.php?id='+id;</script>";
        }
        else
            echo "<script>alert('Email or Password is wrong check again');window.history.back();</script>";
        mysqli_close($c);
    ?>
    </body>
</html>