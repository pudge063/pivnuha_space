<?php if ($page === 'register'): ?>
    <div class="container">
        <form action="../../auth/scripts/register.php" method="post" class="form-example" id="form-example">
            <div>
                <label for="name">Логин: </label>
                <input type="text" name="username" id="username" required maxlength="20" />
            </div>
            <div>
                <label for="name">Имя: </label>
                <input type="text" name="name" id="name" required maxlength="30" />
            </div>
            <div>
                <label for="phone">Телефон: </label>
                <input type="text" name="phone" id="phone" required maxlength="12" />
            </div>
            <div>
                <label for="email">Почта: </label>
                <input type="email" name="email" id="email" required maxlength="30" />
            </div>
            <div>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div>
                <label for="passwordConfirm">Повторите пароль</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" required>
            </div>

            <div class="g-recaptcha" data-sitekey="6LdV-kUqAAAAAODJHAcR6uzeS240zN3zwSNC9slo"></div>

            <div>
                <input type="submit" name="submit" value="Отправить" onclick="sound.play()" />
            </div>
            <div>
                <a href="../auth/login.php">Уже есть аккаунт? Войти</a>
            </div>
        </form>
    </div>
<?php elseif ($page === 'login'): ?>
    <div class="container">
        <h2>Вход</h2>

        <form action="../../controller/ProfileController.php?action=login" method="post" class="form-example" id="form-example">
            <div>
                <label for="name">Логин: </label>
                <input type="text" name="username" id="username" required maxlength="20" />
            </div>

            <div>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="g-recaptcha" data-sitekey="6LdV-kUqAAAAAODJHAcR6uzeS240zN3zwSNC9slo"></div>

            <div>
                <input type="submit" name="submit" value="Отправить" onclick="sound-error.play()" />
            </div>
            <div>
                <a href="../auth/register.php">Уже есть аккаунт? Войти</a>
            </div>
        </form>

    </div>
<?php endif ?>