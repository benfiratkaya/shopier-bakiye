<?php
    require_once("connect.php");
    require_once("functions.php");
    if(isset($_POST["user_id"]) && isset($_POST["first_name"]) && isset($_POST["last_name"])  && isset($_POST["email"]) && isset($_POST["phone_number"]) && isset($_POST["address"]) && isset($_POST["country"]) && isset($_POST["city"]) && isset($_POST["zip_code"]) && isset($_POST["amount"])) {
        require_once("api.php");
        $shopier = new Shopier(API_KEY, API_SECRET);

        $amount = (post("amount")+(post("amount")*COMMISSION/100));

        // ÖDEME YAPAN KİŞİNİN BİLGİLERİ
        $shopier->setBuyer([
            'id' => post("user_id"),
            'first_name' => post("first_name"),
            'last_name' => post("last_name"),
            'email' => post("email"),
            'phone' => post("phone_number")
        ]);
        // VERİLEN SİPARİŞİN FATURASI
        $shopier->setOrderBilling([
            'billing_address'   => post("address"),
            'billing_city'      => post("city"),
            'billing_country'   => post("country"),
            'billing_postcode'  => post("zip_code")
        ]);
        // SİPARİŞİ VEREN KİŞİ - ÜSTTEKİ İLE AYNI BİLGİLERİ GİREBİLİRSİNİZ.
        $shopier->setOrderShipping([
            'shipping_address'  => post("address"),
            'shipping_city'     => post("city"),
            'shipping_country'  => post("country"),
            'shipping_postcode' => post("zip_code")
        ]);

        $insertOrder = $db->prepare("INSERT INTO orders (first_name, last_name, email, phone_number, address, country, city, zip_code, amount, shopier_order_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertOrder->execute(array(
            post("first_name"),
            post("last_name"),
            post("email"),
            post("phone_number"),
            post("address"),
            post("country"),
            post("city"),
            post("zip_code"),
            $amount,
            0,
            0,
            date('Y-m-d H:i:s')
        ));
        $orderID = $db->lastInsertId();

        die($shopier->run($orderID, $amount, CALLBACK_URL));
    }
    else {
        go("/");
    }
