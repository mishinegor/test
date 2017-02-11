<?php
// Соединение с базой данных
$db = mysqli_connect(
    'localhost',
    'root',
    '',
    'ads_base'
) or die("Невозвожно подключиться к базе данных, код ошибки:".mysqli_connect_error());

