<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header class="container">
        <div class="header-item">
            <img src="../assets/static/beer.png" alt="beer">
        </div>
        <div class="header-item">
            <h1>Pivnuha Space</h1>
        </div>
        <div class="header-item">
            <img src="../assets/static/beer.png" alt="beer">
        </div>
    </header>

    <div class="container" hidden="true" id="error-container">
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <script>
                document.getElementById('error-container').removeAttribute('hidden');
            </script>
            <div class="errors">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li style="text-align: center;"><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']);
            ?>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Регистрация</h2>

        <form action="scripts/login.php" method="post" class="form-example" id="form-example">
            <div>
                <label for="name">Логин: </label>
                <input type="text" name="username" id="username" required maxlength="20" />
            </div>

            <div>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <input type="submit" name="submit" value="Отправить" onclick="sound.play()" />
            </div>
        </form>
    </div>

</body>

</html>