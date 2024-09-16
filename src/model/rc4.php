<?php
function rc4Decrypt($key, $cipher)
{
    // RC4 decryption algorithm
    $S = range(0, 255);
    $j = 0;

    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $S[$i] + ord($key[$i % strlen($key)])) % 256;
        // Swap values of $S[$i] and $S[$j]
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
    }

    $i = 0;
    $j = 0;
    $plaintext = '';

    for ($k = 0; $k < strlen($cipher); $k++) {
        $i = ($i + 1) % 256;
        $j = ($j + $S[$i]) % 256;
        // Swap values of $S[$i] and $S[$j]
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]];

        $keyIndex = $S[($S[$i] + $S[$j]) % 256];
        $keystream = $keyIndex ^ ord($cipher[$k]);
        $plaintext .= chr($keystream);
    }

    return $plaintext;
}

