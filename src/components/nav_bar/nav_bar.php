<link rel="preload" href="/components/nav_bar/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/nav_bar/app.css">

<div class="container">
    <div class='button-group'>
        <?php
        if (isset($page)) {
            if ($page === 'index') {
                if (!isset($_SESSION['user_id'])) {
                    echo
                    "
                    <div class='button-group'>
                        <a href='views/auth/register.php' class='button'>Зарегистрироваться</a>
                        <a href='views/auth/login.php' class='button'>Войти</a>
                    </div>";
                } else {
                    echo
                    "
                    <div class='button-group'>
                        <a href='../../views/users/profile.php' class='button profile-button'>Мой профиль</a>
                        <a href='../../controller/UserController.php?action=logout' class='button profile-button'>Выход</a>
                    </div>";
                }
            } elseif ($page === 'register' || $page === 'login') {
                echo "<a href='../../' class='button profile-button'>На главную</a>";
            } elseif ($page === 'profile') {
                if (isset($_SESSION['user_id'])) {
                    echo "
                    <a href='/../../' class='button profile-button'>Главная</a>
                    <a href='/../../controller/UserController.php?action=logout' class='button profile-button'>Выход</a>";
                }
            } elseif ($page === 'user') {
                echo "
                <a href='/../../' class='button profile-button'>Главная</a>";
            }
        }
        ?>
    </div>
</div>