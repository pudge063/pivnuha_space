function rc4Encrypt(key, plaintext) {
    // RC4 encryption algorithm
    var S = [];
    for (var i = 0; i < 256; i++) {
        S[i] = i;
    }

    var j = 0;
    for (var i = 0; i < 256; i++) {
        j = (j + S[i] + key.charCodeAt(i % key.length)) % 256;
        // Swap values of S[i] and S[j]
        var temp = S[i];
        S[i] = S[j];
        S[j] = temp;
    }

    var i = 0;
    var j = 0;
    var cipher = '';
    for (var k = 0; k < plaintext.length; k++) {
        i = (i + 1) % 256;
        j = (j + S[i]) % 256;
        // Swap values of S[i] and S[j]
        var temp = S[i];
        S[i] = S[j];
        S[j] = temp;

        var keyIndex = S[(S[i] + S[j]) % 256];
        var keystream = keyIndex ^ plaintext.charCodeAt(k);
        cipher += String.fromCharCode(keystream);
    }

    return cipher;
}

  var key = "test";

        var jsoned = JSON.stringify(plaintextObject); // turn it inoto plain text
        var encryptedText = rc4Encrypt(key, jsoned); // encrypt it
        var base64Encoded = btoa(encryptedText); // convert to base64

        ws.send(base64Encoded);