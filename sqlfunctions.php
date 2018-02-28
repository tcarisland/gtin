<?php

function connect_gtin() {
    $gtin_servername = "tcarisland.com.mysql";
    $gtin_username = "tcarisland_com_gepir";
    $gtin_password = "gepir_86";
    $gtin_dbname = "tcarisland_com_gepir";
    $gtin_conn = new mysqli($gtin_servername, $gtin_username, $gtin_password, $gtin_dbname);
    if ($gtin_conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $gtin_conn;
}


function disconnect_gtin($gtin_conn) {
    $gtin_conn->close();
}

function query_gtin($q, $gtin_conn) {
  return $gtin_conn->query($q);
}

?>