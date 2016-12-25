<?php require_once 'func.php'?> // Файл с логическими функциями
<!doctype html>
<html lang="en-ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина заказов</title>
</head>
<body>
<style>
    body {
        font-size: 14px;
        font-family: Verdana;
        color:#666;
    }
    h1{
        font-size: 1.8em;
        padding-left: 10%;

    }
    table {
        width: 1200px;
        max-width:90%;
        margin: 2% auto;
        border-spacing: 5px 0px;
        border: 2px solid #cccccc;
        padding: .3% 0;

    }

    tr.caption {
        background-color: #cccccc;
        font-weight:bold;
        font-size: 1.2em;
        color: #ffffff;

    }
    tr {
        color:#ccc;
    }

    td {
        padding: 1.5%;
        border: 1px solid #ccc;
    }

</style>
    <h1>Мои заказы:</h1>
    <table>
        <tr class="caption">
            <td>Наименование товара</td>
            <td>Колличество</td>
            <td>Остаток на складе</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>
</html>


