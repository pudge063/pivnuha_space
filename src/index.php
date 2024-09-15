<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/app.css">
    <title>PIVNUHA SPACE</title>
</head>

<body>
    <div class="container">
        <header>
            <div class="header-item">
                <img src="/assets/static/beer.png" alt="beer">
            </div>
            <div class="header-item">
                <h1>Pivnuha Space</h1>
            </div>
            <div class="header-item">
                <img src="/assets/static/beer.png" alt="beer">
            </div>
        </header>

        <?php
        echo getenv('$MYSQL_USER');
        define($MYSQL_USER, getenv('$MYSQL_USER'));
        define($MYSQL_PASSWORD, getenv('$MYSQL_PASSWORD'));
        define($DB_NAME, 'db_test');
        define($DB_HOST, 'db')
        ?>

        <?php

        $conn = new mysqli($DB_HOST, $MYSQL_USER, $MYSQL_PASSWORD, $DB_NAME);
        if ($conn->connect_error) {
            die("Ошибка: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM test1 order by -create_date limit 30";
        if ($result = $conn->query($sql)) {
            $rowsCount = $result->num_rows;
            echo "<p style='text-align: center;'>Всего записей: $rowsCount</p>";
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
                echo "<td>" . "Нет данных" . "</td>";
                echo "<td>" . "Нет данных" . "</td>";
                echo "<td>" . "Нет данных" . "</td>";
                echo "</tr>";
            }
            echo "</table>";



            $result->free();
        }

        $conn->close();

        ?>
    </div>
    <div class="container">
        <h2>Отметиться</h2>
        <form action="assets/insert_sql.php" method="post" class="form-example">
            <div>
                <label for="name">Имя: </label>
                <input type="text" name="name" id="name" required />
            </div>
            <div>
                <label for="beer">Пиво: </label>
                <input type="text" name="beer" id="beer" required />
            </div>
            <div>
                <input type="submit" value="Отправить!" />
            </div>
        </form>
    </div>
</body>

</html>