<?php
    require_once("connect.php");
    require_once("functions.php");
    if (isset($_POST["platform_order_id"]) && isset($_POST["status"]) && isset($_POST["installment"]) && isset($_POST["payment_id"]) && isset($_POST["random_nr"]) && isset($_POST["signature"])) {
        $signature  = base64_decode(post("signature"));

        $data       = post("random_nr").post("platform_order_id").post("total_order_value").post("currency");
        $expected   = hash_hmac('SHA256', $data, API_SECRET, true);

        if (strcmp($signature, $expected) == 0) {
            if (post("status") == 'success') {
                $checkOrder = $db->prepare("SELECT id, status FROM orders WHERE id = ?");
                $checkOrder->execute(array((int)post("platform_order_id")));
                $orderRead = $checkOrder->fetch();

                if ($checkOrder->rowCount() > 0 && $orderRead["status"] == 0) {
                    $updateOrder = $db->prepare("UPDATE orders SET shopier_order_id = ?, status = ? WHERE id = ?");
                    $updateOrder->execute(array((int)post("payment_id"), 1, $orderRead["id"]));
                }
                go("success.php");
            }
            else {
                go("error.php");
            }
        }
    }
    else {
        go("error.php");
    }