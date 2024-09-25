<div class="container settings-form">
    <h4>Редактировать профиль</h4>
    <form action="../../controller/ProfileController.php?action=edit" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" placeholder="<?php echo ($user['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Новый пароль:</label>
            <input type="password" name="password" id="password" placeholder="Новый пароль">
        </div>

        <!-- <div class="form-group">
                <label for="avatar">Аватар:</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div> -->
        <input type="submit" value="Сохранить изменения" class="submit-button">
    </form>
</div>