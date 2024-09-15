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

    $conn = new mysqli("pivnuha.space", "admin", "123", "db_test");
    if ($conn->connect_error) {
        die("Ошибка: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM test1";
    if ($result = $conn->query($sql)) {
        $rowsCount = $result->num_rows;
        echo "<p>Всего записей: $rowsCount</p>";
        echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["beer"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();

    ?>

    <h2>Отметиться</h2>
    <form action="" method="post" class="form-example">
        <div class="form-example">
            <label for="name">Имя: </label>
            <input type="text" name="name" id="name" required />
        </div>
        <div class="form-example">
            <label for="beer">Пиво: </label>
            <input type="text" name="beer" id="beer" required />
        </div>
        <div class="form-example">
            <input type="submit" value="Отправить!" />
        </div>
    </form>

    <?php
    if (isset($_POST['name']) && isset($_POST['text'])) {

        $name = $_POST['name'];
        $beer = $_POST['beer'];

        $data = array("name" => $name, "beer" => $beer);
        $query = $conn->prepare("INSERT INTO test1 (name, beer) values (:name, :beer)");
        $query->execute($data);

        if ($result) {
            echo "Информация занесена в базу данных";
        }
    }

    ?>

</body>

</html>