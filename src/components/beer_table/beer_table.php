<link rel="preload" href="/components/beer_table/app.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="/components/beer_table/app.css">


<div class="container">

    <?php
    if (isset($table_rows)) {
        $rowsCount = $table_rows->num_rows;
        echo "<p style='text-align: center;'>Увековечены в камне</p>";
        echo "<p style='text-align: center;'>Всего записей: $rowsCount</p>";
        // echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th><th>Дата</th></tr>";
        echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th></tr>";
        foreach ($table_rows as $row) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["beer"] . "</td>";
            // echo "<td>" . $row['create_date'] . "</td>";
            echo "</tr>";
        }

        if ($rowsCount == 0) {
            echo "<tr>";
            echo "<td>" . "Нет данных" . "</td>";
            echo "<td>" . "Нет данных" . "</td>";
            echo "<td>" . "Нет данных" . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>

</div>