<?php
$show = isset($_GET['show']) ? $_GET['show'] : 'menu';
?>
<html>
<head>
  <title>Canteen Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js">
  </script>
</head>
<body>
  <header>
    <h3>Welcome to Canteen Dashboard</h3>
  </header>
  <div class="sidebar">
    <a href="#profile" onclick="showSection('profile')">Profile</a>
    <a href="#menu" onclick="showSection('menu')">Menu</a>
    <a href="#cart" onclick="showSection('cart')">Cart</a>
    <a href="#order" onclick="showSection('order')">Order</a>
  </div>

  <div class="main">
    <div id="profile" class="card" style="display:none;">
      <h2 style="background-color: #6F826A;" >Profile</h2>
      <?php
        $Id = htmlspecialchars($_GET['id']);
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select * from customer where C_id='$Id'";
        $r1=mysqli_query($c,$q1);
        $info=mysqli_fetch_array($r1);
        echo "<div>Id : " .$Id."<br>Name : ".$info['Name']."
        <br>Email : ".$info['Email']."<br>Phone No : ".$info['Ph_no'].
        "<br>Credits : ".$info['Credits'];
      ?>
      <br><br><button type="button" onclick="logout()">Logout</a>
      </div>
      <br>
    </div>

    <div id="menu" class="card" style="display:<?php echo ($show == 'cart') ? 'none' : 'block'; ?>;">
      <h2 style="background-color: #6F826A;" >Menu</h2>
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
          echo "<img src='" .$info['Item_img'] ."' width='250px' height='120px'>
            <b><p>" .$info['Item_name'] ." - Rs" .$info['Item_amt'] ."</b></p>
            <a href='cart.php?id={$info['Item_id']}&c={$Id}'>
            <img src='addtocart.jpg' height='25px' width='40px' alt='Add to cart' style='margin-top: 10px'; ></a></div>";
        }
      ?>
    </div>

    <div id="cart" class="card" style="display:<?php echo ($show == 'cart') ? 'block' : 'none'; ?>;">
        <div style="background-color: #4E6C50; padding: 15px;">
        <h2 style="margin: 0; color: white; background-color: #6F826A;">My Cart</h2>
        <p style="margin: 0; color: white;">Review your order before checkout</p>
        </div>
        <?php
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select c.*,m.* from cart c, menu m where c.Item_id=m.Item_id AND c.C_id='$Id'";
        $r1=mysqli_query($c,$q1);
        if(mysqli_num_rows($r1)>0)
        {
        echo "<style> td,th{padding-left: 20px; padding-right: 20px;}</style>
        <table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: center;'>
        <tr> <th>Item Id</th> <th>Item Image</th> <th>Item Name</th> <th>Item Amount</th> <th>Item count</th> <tr>";
        while($info=mysqli_fetch_array($r1))
        {
         $i=$info['Item_id'];
        echo "<tr> <td>" .$info['Item_id']. "</td> <td><img src='" .$info['Item_img'] ."' width='250px' height='120px'></td> 
            <td>" .$info['Item_name'] ."</td> <td>Rs " .$info['Item_amt'] ."</td> <td> <a href='dec.php?c={$Id}&i={$i}'><button type='button'>-</button></a>
            ". $info['Item_count'] ."<a href='in.php?c={$Id}&i={$i}'><button type='button' style='margin-left:5px'>+</button> </a></td> 
            <td> <a href='removecartitem.php?id={$Id}&i={$i}'><button type='button'>Remove</button> </a> </td> </tr>";
        }
        echo "</table>";
      echo "<div style='padding: 20px; text-align: center;'>
        <br><a href='home.php?id={$Id}' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Continue Shopping</a>
        <a href='orders.php?id={$Id}' style='background-color: #ff5722; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Proceed to Checkout</a>
      </div>";
        }
      ?>
    </div>

    <div id="order" class="card" style="display:none;">
        <?php
        echo "<h2 style='background-color: #6F826A;' >Orders</h2>";
        $Id = htmlspecialchars($_GET['id']);        
        $c=mysqli_connect("localhost","root","","cmanagement");
        if(!$c)
        {
            echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
            exit();
        }
        $q1="select o.Order_no,o.Order_date,o.Order_amt,p.P_status,p.Method from orders o left join payment p on o.Order_no = p.Order_no where o.Cart_id = '$Id'";
        $r1=mysqli_query($c,$q1);
        if(mysqli_num_rows($r1)>0)
        {
        echo "<style> td,th{padding-left: 20px; padding-right: 20px;}</style>
        <table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: center;'>
        <tr> <th>Order_no</th> <th>Order_date</th> <th>Order Amount</th> <th>Payment Status</th> <th>Method</th> <tr>";
        while($info=mysqli_fetch_array($r1))
        {
          $od=$info['Order_no'];
          $displayed_orders[]="";
           if (!in_array($od, $displayed_orders)) 
            {
            echo "<tr> <td>" .$info['Order_no']. "</td> <td>" .$info['Order_date'] ."</td> <td>Rs " .$info['Order_amt'] ."</td>
            <td>" .$info['P_status'] ."</td> <td>" .$info['Method'] ."</td> 
            <td>";if($info['P_status']!='Paid' && $info['Method']!='Cash'){
            echo "<a href='removeorder.php?id={$od}&c={$Id}'>Remove</a></td>";
            echo "<td><a href='payments.php?id={$Id}'><button type='button'>Proceed to Payment</button></a></td>"; } 
            echo "</tr>";
            $displayed_orders[] = $od;
            }
        }
        echo "</table>";
        }
        ?>

  </div>
</body>
</html>