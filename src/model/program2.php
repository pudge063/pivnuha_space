<?php

function isContextFree($productions) {
    foreach ($productions as $production) {
        // X -> α (где X - нетерминал, α - строка терминалов и/или нетерминалов)
        if (preg_match('/^[A-Z] -> [a-zA-Z]+$/', $production) !== 1) {
            return false;
        }
    }
    return true;
}

function isRegular($productions) {
    foreach ($productions as $production) {
        // A -> aB | a (где a - терминал, B - нетерминал)
        if (preg_match('/^[A-Z] -> (aB|a|B)$/', $production) !== 1) {
            return false;
        }
    }
    return true;
}

function determineGrammarType($productions) {
    if (isRegular($productions)) {
        return "Регулярная грамматика (Тип 3)";
    } elseif (isContextFree($productions)) {
        return "Контекстно-свободная грамматика (Тип 2)";
    } else {
        return "Грамматика может быть контекстно-зависимой или неограниченной (Тип 1 или 0)";
    }
}

$productionsA = [
    'A -> aA',
    'B -> bB',
    'C -> cC'
];

$productionsB = [
    'B -> dB',
    'B -> cB',
];

echo "Тип грамматики A: " . determineGrammarType($productionsA) . "<br>";

// echo "Тип грамматики B: " . determineGrammarType($productionsB) . "\n";
?>