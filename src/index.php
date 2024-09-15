<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/app.css">
    <title>Example</title>
</head>

<body>
    <h1>Pivnuha Space</h1>
    <?php

    $conn = new mysqli("pivnuha.space", "admin", "123", "db_test");
    if ($conn->connect_error) {
        die("Ошибка: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM test1 order by create_date limit 30";
    if ($result = $conn->query($sql)) {
        $rowsCount = $result->num_rows;
        echo "<p>Всего записей: $rowsCount</p>";
        echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th><th>Дата</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["beer"] . "</td>";
            echo "<td>" . $row["create_date"] . "</td>";
            echo "</tr>";
        }

        if ($rowsCount == 0) {
            echo "<tr>";
            echo "<td>" . "Sample" . "</td>";
            echo "<td>" . "Sample" . "</td>";
            echo "<td>" . "Sample" . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        

        $result->free();
    }

    /*
    else {
        echo "Ошибка: " . $conn->error;
    }
    */

    $conn->close();

    ?>

    <h2>Отметиться</h2>
    <form action="assets/insert_sql.php" method="post" class="form-example">
        <div class="form-example">
            <label for="name">Имя: </label>
            <input type="text" name="name" id="name" required />
        </div>
        <div class="form-example">
            <label for="beer">Пиво: </label>
            <input type="text" name="beer" id="beer" required />
        </div>
        <div class="form-example">
            <input type="submit" value="Отправить!" />
        </div>
    </form>

</body>

</html>