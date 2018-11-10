<?php
try {
    // open an existing phar
    $p = new Phar('phan-0.9.4.phar', 0);
    $p->
    // Phar extends SPL's DirectoryIterator class
    foreach (new RecursiveIteratorIterator($p) as $file) {
        // $file is a PharFileInfo class, and inherits from SplFileInfo
        echo $file->getFileName() . "\n";
        echo $file->getPathName() . "\n"; // display contents;
        //echo file_get_contents($file->getPathName()) . "\n"; // display contents;
    }
} catch (Exception $e) {
    echo 'Could not open Phar: ', $e;
}
?>