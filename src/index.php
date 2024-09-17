<?php
require_once __DIR__ . '/model/crud.php';
$public_key = getenv("CAPTCHA_PUBLIC_KEY");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/app.css">
    <title>Pivnuha Space!</title>
    <link rel="shortcut icon" href="/src/assets/static/beer.png" />
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("form-example").submit();
        }
    </script>
</head>

<body>
    <header class="container">
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
    <div class="container">

        <?php
        if ($result = read_table($conn)) {
            $rowsCount = $result->num_rows;
            echo "<p style='text-align: center;'>Всего записей: $rowsCount</p>";
            // echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th><th>Дата</th></tr>";
            echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["beer"] . "</td>";
                // echo "<td>" . $row['create_date'] . "</td>";
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
        <form action="/model/insert_sql.php" method="post" class="form-example" id="form-example">
            <div>
                <label for="name">Имя: </label>
                <input type="text" name="name" id="name" required maxlength="20" />
            </div>
            <div>
                <label for="beer">Пиво: </label>
                <input type="text" name="beer" id="beer" required maxlength="20" />
            </div>
            <div class="captcha-wrapper">
                <?php
                echo "<div class='g-recaptcha' data-sitekey=$public_key></div>"
                ?>
            </div>
            <div>
                <input type="submit" name="submit" value="Отправить" />
            </div>
        </form>
        <?php
        echo $public_key;
        echo getenv("CAPTCHA_SECRET_KEY");
        ?>

    </div>

</body>

</html>