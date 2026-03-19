<html>
<head>
  <title>Order Details</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h3>Order Details</h3>
  </header>

  <div class="main">
    <div class="card porder">
      <?php
      if (isset($_GET['id'])) {
          $order_no = $_GET['id'];
          $c = mysqli_connect("localhost", "root", "", "cmanagement");

          if (!$c) {
              die("<script>alert('Database connection failed');</script>");
          }

          // Fetch main order info
          $q1 = "SELECT o.Order_no, o.Cart_id, o.Order_date, o.Order_amt, 
                        p.P_status, p.Method
                 FROM orders o 
                 LEFT JOIN payment p ON o.Order_no = p.Order_no
                 WHERE o.Order_no = '$order_no'";
          $r1 = mysqli_query($c, $q1);

          if ($r1 && $row = mysqli_fetch_assoc($r1)) {
              echo "<h2 style='color:#395144; font-size:24px; margin-bottom:20px;'>Order #" . $row['Order_no'] . "</h2>";

              echo "<table border='0'>";
              echo "<br><br><tr><th>Customer ID</th><td>" . $row['Cart_id'] . "</td></tr>";
              echo "<tr><th>Order Date</th><td>" . $row['Order_date'] . "</td></tr>";
              echo "<tr><th>Total Amount</th><td>Rs " . $row['Order_amt'] . "</td></tr>";
              echo "<tr><th>Payment Status</th><td> " . ($row['P_status'] ?? 'Pending') . "</td></tr>";
              echo "<tr><th>Payment Method</th><td> " . ($row['Method'] ?? 'Not Selected') . "</td></tr><br>";
              echo "</table><br>";

              // Fetch ordered items if stored in ordered_items table
              $q2 = "SELECT items FROM ordered_items WHERE order_no='$order_no'";
              $r2 = mysqli_query($c, $q2);

              echo "<h3 style='color:#395144;'>Items Ordered</h3>";
              if ($r2 && $row2 = mysqli_fetch_assoc($r2)) {
                  echo "<div style='background-color:#F0F1C5; padding:10px 20px; border-radius:10px; width:fit-content; box-shadow:0 2px 6px rgba(0,0,0,0.1);'>";
                  echo htmlspecialchars($row2['items']);
                  echo "</div>";
              } else {
                  echo "<p style='font-style:italic;'>No items found for this order.</p>";
              }

              echo "<br><br><button type='button' onclick='window.history.back()'>Go Back</button>";
          } else {
              echo "<p>No order found for this ID.</p>";
          }

          mysqli_close($c);
      } else {
          echo "<p>Invalid request. No order ID found.</p>";
      }
      ?>
    </div>
  </div>
</body>
</html>