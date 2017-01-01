<?php

// Функция вывода всего списка новостей.
function news_list($news) {
    // Сдвиг индекса на массива на 1
    array_unshift($news, 0);
    unset($news[0]);

    foreach ($news as $key => $val) { //Вывод новостей
        if(isset($_POST['id'])){ // Проверка если новость существует
            echo '<b>'."Новость ".$key.': </b>'.$val.'</br>';
        }
    }
}




// Функция вывода конкретной новости.
function news_item($news)
{
    global $item;

    // Сдвиг индекса на массива на 1
    array_unshift($news, 0);
    unset($news[0]);

    foreach ($news as $key => $val) { //Вывод новостей
        $key = $_POST['id']; // Индекс новости = id
        if (isset($news[$key])) {
            $item = '<b>' . "Новость " . $key . ': </b>' . $news[$key] . '</br>';
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    if ($_POST['id'] < count($news) && isset($_POST['id'])) {
        echo $item;
    } else {
        news_list($news);
    }
}
?>