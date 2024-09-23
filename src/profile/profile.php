<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header class="container header">
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

    <div class="container error-container" id="error-container" hidden>
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
    </div>

    <div class="container profile-info">
        <h2>Профиль <?php echo htmlspecialchars($name); ?></h2>
        <div class="button-group">
            <a href='../../' class='button profile-button'>На главную</a>
            <a href='../auth/scripts/logout.php' class='button profile-button'>Выход</a>
        </div>
    </div>

    <div class="container avatar-upload">
        <h2>Загрузить аватар</h2>
        <form action="scripts/upload_avatar.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="avatar">Выберите файл аватара:</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" required>
            </div>
            <input type="submit" value="Загрузить" class="submit-button">
        </form>
    </div>

</body>

</html>