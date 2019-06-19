<?php
  define('MYSQL_SERVER', 'localhost');
  define('MYSQL_PORT', '3306');
  define('MYSQL_USERNAME', 'root');
  define('MYSQL_PASSWORD', 'sifre');
  define('MYSQL_DATABASE', 'shopier');

  define('API_KEY', 'Shopier API Key Giriniz'); // Shopier API Key
  define('API_SECRET', 'Shopier API Secret Giriniz'); // Shopier API Secret
  define('CALLBACK_URL', 'https://www.siteniz.com/callback.php');
  define('COMMISSION', 5); // Yüzde kaç komisyon eklensin? İstemiyorsanız 0 yazınız.

  try {
    $db = new PDO('mysql:host='.MYSQL_SERVER.'; port='.MYSQL_PORT.'; dbname='.MYSQL_DATABASE.'; charset=utf8', MYSQL_USERNAME, MYSQL_PASSWORD);
  }
  catch (PDOException $e) {
    print '<strong>MySQL bağlantı hatası:</strong> '.$e->getMessage();
  }
?>