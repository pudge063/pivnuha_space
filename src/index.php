<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>

<body>
    <h1>Example</h1>
    <?php

    $conn = new mysqli("db", "admin", "123", "db_test");
    if ($conn->connect_error) {
        die("Ошибка: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM test1";
    if ($result = $conn->query($sql)) {
        $rowsCount = $result->num_rows;
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Id</th><th>Имя</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();

    ?>
    <a href="http://google.com">google</a>
    <a href="http://gitlab.psuti.fun">Gitlab Local</a>
    <a href="http://phpmyadmin.psuti.fun">phpmyadmin</a>

    <?php
    echo '1';
    echo '<br>';
    $x = 1;
    $y = 1;
    if ($x++ == 1) {
        print($x);
    }
    echo '<br>';
    if (++$y == 2) {
        print($x);
    }
    echo "<br>";
    $a = array('123', '234', '345');
    // print($a);
    print($a[1]);
    ?>

</body>

</html>