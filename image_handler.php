<?php
declare(strict_types=1);

# image handler function
function directoryHandler(string $inputHandle, array $stripOut = ['.', '..']): mixed
{
    // hold all files
    $files = [];

    # check input directory is legitimate or not
    if (!is_dir($inputHandle) && !(opendir($inputHandle))) {
        return null;
    }

    // open input directory
    $dirHandle = opendir($inputHandle);

    # read input directory and get all files
    while (false !== ($file = readdir($dirHandle))) {
        if (!in_array($file, $stripOut)) {
            $files[] = $inputHandle . '/' . $file;
        }
    }
    closedir($dirHandle);

    return $files;
}

// list all allowed file types
$allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg', 'image/bmp'];

// list all allowed file sizes
$maxSize = (1024 * 1024);

// validate file type
function typeValidation(array $fileHandle, array $allowed): bool
{
    foreach ($fileHandle['type'] as $value) {
        if (!in_array($value, $allowed)) {
            return false;
        }
    }

    return true;
}

// validate file size
function sizeValidation(array $fileHandle, int $maxSize): bool
{
    foreach ($fileHandle['size'] as $value) {
        if ($value > $maxSize) {
            return false;
        }
    }

    return true;
}

// upload file mechanism
function fileUploadHandler(array $fileHandle, array $allowed, int $maxSize)
{
    if ($fileHandle) {
        if (typeValidation($fileHandle, $allowed) === false) {
            echo ("<b style='color: red; font-size: 20px; font-weight: bold; display: block; margin-top: 20px; text-align: center;'>Only " . implode(', ', ($allowed)) . " files are allowed</b>");
        } else if (sizeValidation($fileHandle, $maxSize) === false) {
            echo ("<b style='color: red; font-size: 20px; font-weight: bold; display: block; margin-top: 20px; text-align: center;'>File size must be less than " . $maxSize . " bytes</b>");
        } else {
            foreach ($fileHandle['tmp_name'] as $key => $value) {
                $fileName = $fileHandle['name'][$key];
                $fileTmp = $value;
                move_uploaded_file($fileTmp, 'gallery/uploaded-' . $fileName);
            }
        }
    }
}