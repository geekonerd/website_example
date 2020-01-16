<?php

/**
 * get uploaded file
 * @return string filename
 * @throws RuntimeException
 */
function get_uploaded_file() {
    try {

        // check Undefined | Multiple Files | $_FILES["file"] Corruption Attack
        if (!isset($_FILES["file"]['error']) ||
                is_array($_FILES["file"]['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }

        // check $_FILES["file"]['error'] value
        switch ($_FILES["file"]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // check filesize
        if ($_FILES["file"]['size'] > 10240000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // check MIME Type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES["file"]['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif'
                ), true)) {
            throw new RuntimeException('Invalid file format.');
        }

        // name it uniquely.
        $filename = sha1_file($_FILES["file"]['tmp_name']);
        if (!move_uploaded_file($_FILES["file"]['tmp_name'],
                        sprintf("../assets/files/%s.%s", $filename, $ext))) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        // return filename
        return $filename . "." . $ext;
    } catch (RuntimeException $e) {
        trigger_error('Error: ' . $e, E_USER_ERROR);
        return null;
    }
}

/**
 * generate random string
 * @return string the random password
 * @throws Exception
 */
function random_str($length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {

    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
