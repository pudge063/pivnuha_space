<div class="container">

    <?php
    if ($result = read_table($conn)) {
        $rowsCount = $result->num_rows;
        echo "<p style='text-align: center;'>Увековечено в камне</p>";
        echo "<p style='text-align: center;'>Всего записей: $rowsCount</p>";
        // echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th><th>Дата</th></tr>";
        echo "<table class='index-table'><tr><th>Имя</th><th>Пиво</th></tr>";
        foreach ($result as $row) {
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


        $result->free();
    }

    $conn->close();

    ?>

</div>