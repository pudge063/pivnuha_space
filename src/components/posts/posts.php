<link rel="preload" href="/components/posts/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/posts/app.css">


<div class='container'>
    <h2>Посты</h2>
    <?php if ($posts && $posts->num_rows > 0): ?>
        <?php while ($row = $posts->fetch_assoc()): ?>
            <div class='post-item'>
                <div class='post-header'>
                    <a href='../../views/users/users.php?id=<?= $row['user_id'] ?>'>
                        <?php
                        if ($row['is_admin'] == 1) {
                            $borderColor = "6f42c1";
                        } else {
                            $borderColor = "gray";
                        }
                        ?>
                        <img src='<?= $row['avatar'] ?>' alt='Аватар' class='avatar' style="border: 2px solid <?= $borderColor; ?>;">
                    </a>
                    <div class='user-info'>
                        <h3 class='username'><a href='../../views/users/users.php?id=<?= $row['user_id'] ?>'><?= htmlspecialchars($row['name']) ?></a></h3>
                        <span class='post-date'><?= htmlspecialchars($row['date']) ?></span>
                    </div>
                    <?php if (isset($user_id) && $row['user_id'] == $user_id || isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
                        <form action='../../controller/PostController.php?action=delete' method='POST' style='display: inline;'>
                            <input type='hidden' name='post_id' value='<?= $row['id'] ?>'>
                            <button type='submit' class='delete-button'>Удалить</button>
                        </form>
                    <?php endif; ?>
                </div>
                <p class='post-content'><?= htmlspecialchars($row['text']) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Нет постов для отображения.</p>
    <?php endif; ?>
</div>