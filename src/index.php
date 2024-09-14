<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>

<body>
    <h1>Example</h1>
    <?php
    echo "Test";
    echo "<br>";
    $mysqli = mysqli_connect('db', 'admin', '123', 'db_test');
    $result = $mysqli->query("SELECT * FROM test1 LIMIT 10");
    printf($result->num_rows);
    echo "<br>";
    echo "Ok!";
    ?>
</body>

</html>