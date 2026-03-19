<html>
<head>
    <title>signup</title>
</head>
    <body>
    <?php
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $name=$_POST["na"];
        $email=$_POST["em"];
        $con=$_POST["cn"];
        $password=$_POST["ps"];
        $q1="insert into customer (Name,Email,Ph_no,Password,Roll_name) values('$name','$email','$con','$password','Customer')";
        $r1=mysqli_query($c,$q1);
        if($r1)
            echo "<script>alert('User Registered successfully'); window.location.href = 'signin.html';</script>";
        else
            echo "<script>alert('Failed to Register'); window.history.back();</script>";
        mysqli_close($c);
    ?>
    </body>
</html>