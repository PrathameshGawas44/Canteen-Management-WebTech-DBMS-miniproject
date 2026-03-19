<html>
<head>
  <title>Remove Item</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js">
  </script>
</head>
<body style="margin:20px;">
    <div>
      <h2 style="background-color: #6F826A; color:white; text-align:center;">Menu</h2>
      <?php
      $Id = htmlspecialchars($_GET['id']);
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select * from menu";
        $r1=mysqli_query($c,$q1);
        echo "<style> td,th{padding: 5px; border: 2px solid black;} table{border:2px solid black;}</style>
        <table>
        <tr> <th>Item Id</th> <th>Item Image</th> <th>Item Name</th> <th>Item Amount</th> <th>Remove Item</th><tr>";
        while($info=mysqli_fetch_array($r1))
        {
          echo "<tr> <td>" .$info['Item_id']. "</td> <td><img src='" .$info['Item_img'] ."' width='200px' height='50px'></td> 
            <td>" .$info['Item_name'] ."</td> <td>Rs " .$info['Item_amt'] ."</td> <td><a href='d.php?id={$info['Item_id']}&c={$Id}'>
            <button type='button'>Remove Item</button></a></td> </tr>";
        }
        echo "</table>";
        echo "<br><a href='Adminhome.php?id={$Id}'><button type='button' id='btn2' name='btn2'>Go Back</button></a>";
      ?>
    </div>
</body>
</html>