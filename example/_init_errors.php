<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = [
        'password' => 'Sample error message',
        'gender' => 'Sample error message',
        'cv' => 'Sample error message',
        'message' => 'Sample error mesage',
    ];
} else {
    $_SESSION['errors'] = [];
}