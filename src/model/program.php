<?php
echo "start";

$res = '';
$a = 'cd';
$b = 'c';

function add_A($res, $a)
{
    return $res . $a;
}

function add_B($res, $b) {
    $b .= $b;
    return $b;
}

for ($i = 0; $i < 10; $i++) {
    printf($res . "<br>");
    if ($i == 0) {
        $res = add_A($res, $a);
    }
    $res .= add_B($res, $b);
}

$a = array('cd', 'cc', 'dd', 'dc');
$b = array("d", "c");
