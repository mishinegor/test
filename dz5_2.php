<?php
header('Content-Type: text/html; charset= windows-1251');
require_once ('func_post.php');
error_reporting( E_ERROR ); // ��������� �����������
//POST

$news='������ ������������� �������� ����� � ����� ������ �������������
�������� ������������� ���: ������ ����� ���������
������ �������������������� �� �������� �������� ������ 5-� �������� � �����������
�������-������������ ������� ���������� ������������
������: �������� �������� ������ ��� ����� � ����� ����� ����-���
�������� �������: �������������� ���������
���� ������� �������: ��������, ������ ������ � ������� ������� � �����
�������� ����� ������ ������� �� ������ ��������� �� ������ � �� ��������� ���������� ������
������ ������� ������ ������ �������� � ���� ������� ����� � �����������';
$news=  explode("\n", $news);


// ������� ������ ����� ������ ��������.

// ������� ������ ���������� �������.

// ����� �����.
// ���� ������� ������������ - ������� �� �� �����, ����� �� ������� ���� ������

// ��� �� ������� id ������� � �������� ���������?
// ���� �������� �� ��� ������� - �������� 404 ������
// http://php.net/manual/ru/function.header.php
?>

<!doctype html>
<html lang="en-ru">
<head>
    <meta charset="windows-1251">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>����� Post</title>
</head>
<body>
<form method="post">
    <label for="id">������� ��������</label>
    <input type="text" name="id">
    <input type="submit" value="���������">
</form>
<br/>
<?php news_item($news); ?>
</body>
</html>


