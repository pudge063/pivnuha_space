<link rel="preload" href="/components/profile_edit/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/profile_edit/app.css">

<div class="container settings-form">
    <h4>Редактировать профиль</h4>
    <form action="../../controller/UserController.php?action=edit" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" placeholder="<?php echo htmlspecialchars($user['name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" placeholder="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Новый пароль:</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="btn-group">
            <input type="submit" value="Сохранить изменения" class="submit-button">
        </div>
    </form>
</div>