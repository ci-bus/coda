<?php
    function getNameFile() {
        $link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $link = str_replace(array("&redocache=1", "?redocache=1"), array("", ""), $link);
        $carpeta = "archivos_cache";
        if (!is_dir($carpeta)) {
            mkdir($carpeta);
        }
        $archivo = $carpeta."/".md5($link);
        return $archivo;
    }

    function bufferCallBack($buffer) {
        if (strlen($buffer) > 0) {
            $file = getNameFile();
            touch($file);
            $fh = fopen($file, 'w');
            fwrite($fh, $buffer);
            fclose($fh);
        }
        return $buffer;
    }

    $file = getNameFile();
    if (file_exists($file) && $_GET['redocache'] !== "1") {
        echo file_get_contents($file);
        die();
    }
    ob_start('bufferCallBack');
?>