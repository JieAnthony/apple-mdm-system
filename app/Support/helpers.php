<?php

if (! \function_exists('temporaryCertificateGenerate')) {
    function temporaryCertificateGenerate(string $content)
    {
        $tmpKey = tempnam(sys_get_temp_dir(), 'key_');
        file_put_contents($tmpKey, $content);

        return $tmpKey;
    }
}
