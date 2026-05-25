<?php

$conn = mysqli_connect(
    "zephyr.proxy.rlwy.net",
    "root",
    "DZASDKpuoeLOfkDKIMeTxPtkkKfNvnoc",
    "railway",
    32147
);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

?>