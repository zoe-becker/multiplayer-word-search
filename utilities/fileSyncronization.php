<?php
// Several functions that provide synchronized access to shared files such as
// lobby/game files where potential race conditions exist on the datafiles

// Acquire a shared (read) lock on a file and return the contents of the file
// $file: path to the file to be read. The lock is automatically released after the read
// returns: the contents of the file
function flock_read($file) {
    $stream = fopen($file, "r");
    $lock = flock($stream, LOCK_SH); // lock file
    
    if (!$lock) {
        trigger_error("unable to obtain lock on $file", E_ERROR);
    }

    $data = fread($stream, filesize($file)); // read contents
    flock($stream, LOCK_UN); // unlock file

    return $data;
}

// Acquire an exclusive read/write lock on the file, must be released by user
// returns: stream pointer (used to release lock)
function flock_acquireEX($file) {
    $stream = fopen($file, "c+"); // open for read/write without truncating
    $lock = flock($stream, LOCK_EX);

    if (!$lock) {
        trigger_error("unable to obtain lock on $file", E_ERROR);
    }

    return $stream;
}

// Acquire an exclusive (write) lock on a file and write data to file
// Automatically releases lock after the write
// returns: true on success
function flock_write($file, $data) {
    $stream = fopen($file, "w");
    $lock = flock($stream, LOCK_EX);

    if (!$lock) {
        trigger_error("unable to obtain lock on $file", E_ERROR);
    }

    $success = fwrite($stream, $data);
    return !($success === false);
}

// Release a lock
function flock_release($stream) {
    flock($stream, LOCK_UN);
}

?>