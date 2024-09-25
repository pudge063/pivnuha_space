<link rel="preload" href="/components/error_form/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/error_form/app.css">

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
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
</div>