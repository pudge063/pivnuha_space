<link rel="preload" href="/components/create_post/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/create_post/app.css">


<div class="container">
    <h2>Создать пост</h2>
    <?php
    if (isset($user_id)) {
        $placeholder = "$username, что у вас на уме?";
    } else {
        $placeholder = "Войдите или зарегистрируйтесь, чтобы добавить пост.";
    }
    ?>
    <form action="../../controller/PostController.php?action=create" method="post" class="post-form">
        <?php
        echo "<textarea name='post_content' id='create_post_content' placeholder='$placeholder' required></textarea>";
        ?>
        <div class="button-container">
            <?php
            if (isset($user_id)) {
                echo "<input type='submit' value='Отправить' class='submit-button'>";
            } else {
                echo "<input type='submit' value='Отправить' class='submit-button' disabled'>";
            }
            ?>
        </div>
    </form>
</div>