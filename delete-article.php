<?php
$articleDB= require_once __DIR__  . '/database/Articledb.php';
$_GET= filter_input_array(INPUT_GET,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if($id) {
    $articleDB->deleteOne($id);
    header('Location: /dyma/Php/blog_version1/');
} 
