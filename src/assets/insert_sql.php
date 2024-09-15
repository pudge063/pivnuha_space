<?php

if (isset($_POST['name']) && isset($_POST['beer'])) {
    $name = $_POST['name'];
    $beer = $_POST['beer'];

    $con = mysqli_connect("db", "admin", "123", "db_test");
    mysqli_set_charset($con, "utf8");

    if (mysqli_connect_errno()) {
        echo "провал" . mysqli_connect_error();
    }
    $query1 = "INSERT INTO test1 VALUES ($name, $beer);";
    $result1 = mysqli_query($con, $query1);

    if ($result1 = 'true') {
        echo "Информация занесена в базу данных";
    } else {
        echo "Информация не занесена в базу данных";
    }
}
