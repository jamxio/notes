<?php

$name = $_GET['name'] ?? '';

$postData = file_get_contents('php://input');

file_put_contents('dumps/' . $name . date('YmdHis') . '.html', $postData);

