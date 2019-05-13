<?php

function filetime($file): string
{
    $filename = public_path() . DIRECTORY_SEPARATOR . $file;
    if (file_exists($filename)) {
        return DIRECTORY_SEPARATOR . $file . '?time=' . filemtime($filename);
    }
    return 'Error! File not found: ' . $file;
}
