<?php
// require_once __DIR__ . '/model/rc4.php'
require_once __DIR__ . '/model/crud.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/app.css">
    <title>Pivnuha Space</title>
    <link rel="shortcut icon" href="/src/assets/static/beer.png" />
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

        $conn->close();

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
            <!-- <div>
                <input type="checkbox" id="politics" onclick="check();" value="" autocomplete="off" />
                Даю согласие на обработку данных
            </div> -->
            <div>
                <input type="submit" name="submit" value="Отправить"
                    class="g-recaptcha"
                    data-sitekey="6LdJ9kUqAAAAACwPRLF4m1lLVHJ7lC7m9OC4C5R3"
                    data-callback='onSubmit'
                    data-action='submit' />
                <script src="https://www.google.com/recaptcha/api.js"></script>

                <script>
                    function onSubmit(token) {
                        document.getElementById("form-example").submit();
                    }
                </script>

                <button
                    class="g-recaptcha"
                    data-sitekey="6LdJ9kUqAAAAACwPRLF4m1lLVHJ7lC7m9OC4C5R3"
                    data-callback='onSubmit'
                    data-action='submit'>
                    Отправить
                </button>

            </div>
        </form>

        <!-- <script>
            function check() {
                var submit = document.getElementsByName('submit')[0];
                if (document.getElementById('politics').checked)
                    submit.disabled = '';
                else
                    submit.disabled = 'disabled';
            }
        </script> -->
    </div>

    <div class="container" hidden>
        <?php
        // $key = '0123456789abcdef';
        // $data = 'Hello World!';
        // $res = rc4($key, $data);
        // echo "initial text: " . $data . "<br>";
        // echo "decrypted by rc4: " . $res . "<br>;";
        // printf("encrypted by rc4: " . rc4($key, $res));
        ?>
    </div>
</body>

</html>