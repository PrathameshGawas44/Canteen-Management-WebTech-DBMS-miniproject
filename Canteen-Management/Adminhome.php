<html>
<head>
  <title>Admin Canteen Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js">
  </script>
</head>
<body>
  <header>
    <h3>Welcome to Admin Canteen Dashboard</h3>
  </header>
  <div class="sidebar" id="s1">
    <a href="#" onclick="showSectionA('profile')">Profile</a>
    <a href="#" onclick="showSectionA('menu')">Menu</a>
    <a href="#" onclick="showSectionA('orders')">Orders</a>
  </div>

  <div class="main">
    <div id="profile" class="card" style="display:none;">
      <h2 style="background-color: #6F826A;">Profile</h2>
      <?php
        $Id = htmlspecialchars($_GET['id']);
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select * from admin where A_id='$Id'";
        $r1=mysqli_query($c,$q1);
        $info=mysqli_fetch_array($r1);
        echo "<div>Id : " .$Id."<br>Email : ".$info['Email']."<br>Credits : ".$info['Credits'];
      ?>
      <br><br><button type="button" onclick="logout()">Logout</a>
      </div>
      <br>
    </div>
    <div id="menu" class="card" style="display:none;">
      <h2 style="background-color: #6F826A;">Menu</h2>
      <?php
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select * from menu";
        $r1=mysqli_query($c,$q1);
        while($info=mysqli_fetch_array($r1))
        {
          echo "<div>";
          echo "<b><img src='" .$info['Item_img'] ."' width='250px' height='120px'>
            <p>" .$info['Item_name'] ." - Rs" .$info['Item_amt'] ."</p></div>";
        }
        echo "<br><br><a href='add.html'><button type='button' style='margin-left:20px'>Add Item</button></a>
        <br><br><a href='delete.php?id={$Id}'><button type='button' style='margin-left:20px'>Remove Item</button></a>";
      ?>
      
      <br><br>
    </div>
    <div id="orders" class="card">
      <h2 style="background-color: #6F826A;">Pending Orders</h2>
      <?php
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select o.Cart_id,o.Order_no,o.Order_date,o.Order_amt,p.P_status,p.Method from orders o left join payment p on o.Order_no = p.Order_no";
        $r1=mysqli_query($c,$q1);
        if(mysqli_num_rows($r1)>0)
        {
        echo "<style> td,th{padding-left: 20px; padding-right: 20px;}</style>
        <table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: center;'>
        <tr> <th>Order_no</th> <th>Customer_id</th> <th>Order_date</th> <th>Order Amount</th> <th>Payment Status</th> <th>Method</th> <tr>";
        while($info=mysqli_fetch_array($r1))
        {
        $od=$info['Order_no'];
          $displayed_orders[]="";
           if (!in_array($od, $displayed_orders)) 
            {    
            if($info['P_status']=='Paid' || $info['Method']=='Cash'){    
                $o=$info['Order_no'];
                echo "<tr> <td>" .$info['Order_no']. "</td> <td>" .$info['Cart_id']. "</td> <td>" .$info['Order_date'] ."</td> 
                <td>Rs " .$info['Order_amt'] ."</td> <td>" .$info['P_status'] ."</td> <td>" .$info['Method'] ."</td>
                <td> <a href='odetail.php?id={$o}'><button type='button'>Details</button></a> </td>  </tr>";
                $displayed_orders[] = $o;
            }
            }
        }
        echo "</table>";
        }
      ?>
    </div>
  </div>
</body>
</html>