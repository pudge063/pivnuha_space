<?php
require_once __DIR__ . '/connect.php';

function read_table($conn)
{
    $sql = "SELECT * FROM test1 order by -create_date limit 30";
    return $conn->query($sql);
}
