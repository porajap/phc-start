<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");


getCurrentEndDate($conn);

function getCurrentEndDate($conn)
{
    $sql = "SELECT
                *
            FROM perioddallycall per
            WHERE DATE(eDate) = DATE(NOW())  LIMIT 1";
    $meQuery = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($meQuery);
    echo json_encode($result);
}