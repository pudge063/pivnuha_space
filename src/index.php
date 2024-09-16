<?php
require_once __DIR__ . '/model/connect.php';
require_once __DIR__ . '/model/rc4.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/app.css">
    <title>Pivnuha Space</title>
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
        // $db_host = 'db';
        // $db_user = getenv("MYSQL_USER");
        // $db_password = getenv("MYSQL_PASSWORD");
        // $db_name = 'db_test';
        ?>

        <?php

        // $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
        // if ($conn->connect_error) {
        //     die("Ошибка: " . $conn->connect_error);
        // }
        $sql = "SELECT * FROM test1 order by -create_date limit 30";
        if ($result = $conn->query($sql)) {
            $rowsCount = $result->num_rows;
            echo "<p style='text-align: center;'>Всего записей: $rowsCount</p>";
            echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th><th>Дата</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["beer"] . "</td>";
                echo "<td>" . $row['create_date'] . "</td>";
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

        // $conn->close();

        ?>

    </div>
    <div class="container">
        <h2>Отметиться</h2>
        <form action="assets/insert_sql.php" method="post" class="form-example">
            <div>
                <label for="name">Имя: </label>
                <input type="text" name="name" id="name" required maxlength="10" />
            </div>
            <div>
                <label for="beer">Пиво: </label>
                <input type="text" name="beer" id="beer" required maxlength="10" />
            </div>
            <div>
                <input type="checkbox" id="politics" onclick="check();" value="" autocomplete="off" />
                Даю согласие на обработку данных
            </div>
            <div>
                <input type="submit" name="submit" value="Отправить" disabled="" />
            </div>

            <?php
            // echo $_SERVER['REMOTE_ADDR'];
            // echo "<br>" . $_SERVER['HTTP_USER_AGENT'];
            // echo "<br>" . $ip;
            ?>
        </form>
        <script>
            function check() {
                var submit = document.getElementsByName('submit')[0];
                if (document.getElementById('politics').checked)
                    submit.disabled = '';
                else
                    submit.disabled = 'disabled';
            }
        </script>
    </div>

    <div class="container">
        <?php
        $key = "0123456789abcdef";
        $data = "Hello World!";
        $res = rc4($key, $res);
        echo $res;
        ?>
    </div>
</body>

</html>