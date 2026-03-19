<html>
<body>
<?php
    $Id = htmlspecialchars($_GET['id']);
    $c = mysqli_connect("localhost", "root", "", "cmanagement");
    if (!$c) {
        echo "<script>alert('Error: Could not connect to database.'); window.history.back();</script>";
        exit();
    }

    // Step 1: Calculate total order amount
    $q2 = "SELECT SUM(m.Item_amt * c.Item_count) AS Amount 
           FROM menu m, cart c 
           WHERE c.Item_id = m.Item_id AND c.Cart_id = '$Id'";
    $r2 = mysqli_query($c, $q2);

    if ($r2) {
        $row = mysqli_fetch_array($r2);
        $amt = $row['Amount'];

        if ($amt === null) {
            echo "<script>alert('Error: Cannot place an empty order.'); window.history.back();</script>";
            exit();
        }

        // Step 2: Insert into orders (same as before)
        $q1 = "INSERT INTO orders (Cart_id, Order_amt) VALUES ('$Id', '$amt')";
        $r1 = mysqli_query($c, $q1);

        if ($r1) {
            // Get the latest order number
            $order_no = mysqli_insert_id($c);

            // Fetch item names and quantities
            $q_items = "SELECT m.Item_name, c.Item_count 
                        FROM cart c 
                        JOIN menu m ON c.Item_id = m.Item_id 
                        WHERE c.Cart_id = '$Id'";
            $r_items = mysqli_query($c, $q_items);

            $item_list = "";
            while ($item = mysqli_fetch_assoc($r_items)) {
                $item_list .= $item['Item_name'] . "×" . $item['Item_count'] . ", ";
            }

            // Remove trailing comma and space
            $item_list = rtrim($item_list, ", ");

            // Insert item details into ordered_items table
            $q_insert = "INSERT INTO ordered_items (Order_no, Items) VALUES ('$order_no', '$item_list')";
            $r_insert = mysqli_query($c, $q_insert);

            if ($r_insert) {
                $query="delete from cart where Cart_id='$Id'";
                $r=mysqli_query($c,$query);
                echo "<script>alert('Order placed successfully'); window.location.href = 'home.php?id={$Id}'; </script>";
            } else {
                echo "<script>alert('Order placed, but failed to save item details'); window.location.href = 'home.php?id={$Id}'; </script>";
            }
        } else {
            echo "<script>alert('Failed to place order'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Failed to calculate order total.'); window.history.back();</script>";
    }

    mysqli_close($c);
?>
</body>
</html>
