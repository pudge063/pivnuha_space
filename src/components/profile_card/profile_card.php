<link rel="preload" href="/components/profile_card/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/profile_card/app.css">

<div class="container profile-container">
    <div class="profile-avatar">
        <img src="<?php echo htmlspecialchars($user['avatar'] ?? '../assets/static/uploads/avatar.png'); ?>" alt="Аватар" class="avatar">
    </div>
    <div class="profile-details">
        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
        <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Почта:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Дата регистрации:</strong> <?php echo htmlspecialchars($user['reg_date']); ?></p>
    </div>
</div>