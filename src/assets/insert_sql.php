<?php

if (isset($_POST['name']) && isset($_POST['beer'])) {
    $name = $_POST['name'];
    $beer = $_POST['beer'];

    $conn = mysqli_connect("pivnuha.space", "admin", "123", "db_test");
    mysqli_set_charset($conn, "utf8");

    if (mysqli_connect_errno()) {
        echo "провал" . mysqli_connect_error();
    }
    $query1 = "INSERT INTO test1 (name, beer) VALUES ($name, $beer);";
    $result1 = mysqli_query($conn, $query1);

    // if ($result1 = 'true') {
    //     echo "Информация занесена в базу данных";
    // } else {
    //     echo "Информация не занесена в базу данных";
    // }
}

header("Location: ../index.php");