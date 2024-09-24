<?php
require_once __DIR__ . '/model/crud.php';
$public_key = getenv("CAPTCHA_PUBLIC_KEY");


session_start();
// $user_id = -1;
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['name'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/app.css">
    <link rel="stylesheet" href="assets/menu.css">
    <link rel="stylesheet" href="assets/new_post.css">
    <link rel="stylesheet" href="assets/posts.css">
    <title>Pivnuha Space!</title>
    <link rel="shortcut icon" href="/src/assets/static/beer.png" />
    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->

    <!-- <script>
        function onSubmit(token) {
            document.getElementById("form-example").submit();
        }
    </script> -->
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

    <?php
    if (!isset($_SESSION['user_id'])) {
        echo
        "<div class='container'>
                <div class='button-group'>
                <a href='/auth/register.php' class='button'>Зарегистрироваться</a>
                <a href='/auth/login.php' class='button'>Войти</a>
            </div>
        </div>";
    } else {
        echo
        "<div class='container'>
            <div class='button-group'>
                <a href='profile/profile.php' class='button profile-button'>Мой профиль</a>
                <a href='auth/scripts/logout.php' class='button profile-button'>Выход</a>
            </div>
        </div>";
    }
    ?>


    <div class="container">
        <p style="text-align: center; margin: 0; padding: 0;">Однажды pivnuha.space будет по умолчанию в закладках Chrome</p>
    </div>

    <div class="container">
        <h2>Создать пост</h2>
        <?php
        if (isset($user_id)) {
            $placeholder = "$username, что у вас на уме?";
        } else {
            $placeholder = "Войдите или зарегистрируйтесь, чтобы добавить пост.";
        }
        ?>
        <form action="assets/helpers/create_post.php" method="post" class="post-form">
            <?php
            echo "<textarea name='post_content' id='post_content' placeholder='$placeholder' required></textarea>";
            ?>
            <div class="button-container">
                <?php
                if (isset($user_id)) {
                    echo "<input type='submit' value='Отправить' class='submit-button'>";
                } else {
                    echo "<input type='submit' value='Отправить' class='submit-button' onclick='playSilence()'>";
                }
                ?>
            </div>
        </form>
    </div>


    <div class='container'>
        <h2>Посты</h2>
        <?php
        if ($result = read_posts($conn)) {
            $rowsCount = $result->num_rows;
            foreach ($result as $row) {
                echo "
            <div class='post-item'>
                <div class='post-header'>
                    <a href='profile/users.php?id=" . $row['user_id'] . "'>
                        <img src='" . $row['avatar'] . "' alt='Аватар' class='avatar'>
                    </a>
                    <div class='user-info'>
                        <h3 class='username'><a href='profile/users.php?id=" . $row['user_id'] . "'>" . $row['name'] . "</a></h3>
                        <span class='post-date'>" . $row['date'] . "</span>
                    </div>";
                if (isset($user_id) && $row['user_id'] == $_SESSION['user_id']) {
                    echo "
                    <form action='assets/helpers/delete_post.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='post_id' value='" . $row['id'] . "'>
                        <button type='submit' class='delete-button'>Удалить</button>
                    </form>";
                }
                echo "
                </div>
                <p class='post-content'>" . htmlspecialchars($row['text']) . "</p>
            </div>";
            }
        }
        ?>
    </div>

    <div class="container">

        <?php
        if ($result = read_table($conn)) {
            $rowsCount = $result->num_rows;
            echo "<p style='text-align: center;'>Увековечено в камне</p>";
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
    <!-- <div class="container">
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

                <div class='g-recaptcha' data-sitekey="6LdV-kUqAAAAAODJHAcR6uzeS240zN3zwSNC9slo"></div>

            </div>
            <div>
                <input type="submit" name="submit" value="Отправить" onclick="sound.play()" />
            </div>
        </form>

    </div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.js"></script>
    <script src='assets/sounds.js'></script>

</body>

</html>