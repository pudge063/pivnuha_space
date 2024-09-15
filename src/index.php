<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/app.css">
    <title>Example</title>
</head>

<body>
    <header>
        <div class="header-line">
            <div class="header-image">

            </div>
            <div class="header-link">
                <a href="https://gitlab.pivnuha.space">Gitlab Local</a>
            </div>
            <div class="header-link">
                <a href="https://admin.pivnuha.space">Gitlab Local</a>
            </div>

        </div>
    </header>
    <h1>Example</h1>
    <?php

    $conn = new mysqli("db", "admin", "123", "db_test");
    if ($conn->connect_error) {
        die("Ошибка: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM test1";
    if ($result = $conn->query($sql)) {
        $rowsCount = $result->num_rows;
        echo "<p>Всего записей: $rowsCount</p>";
        echo "<table class='index-table'><tr><th>Id</th><th>Имя</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();

    ?>

</body>

</html>