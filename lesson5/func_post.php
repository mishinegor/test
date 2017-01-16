<?php

// Функция вывода всего списка новостей.
function news_list($news)
{
    // Сдвиг индекса на массива на 1
    array_unshift($news, 0);
    unset($news[0]);
    foreach ($news as $key => $val) { //Вывод новостей
        echo '<b>' . "Новость " . $key . ': </b>' . $val . '</br>';
    }
}



// Функция вывода конкретной новости.
function news_item($news)
{
    static $item;

    // Сдвиг индекса на массива на 1
    if(isset($_POST['id'])) { // Проверка если новость существует)
        array_unshift($news, 0);
        unset($news[0]);
        foreach ($news as $key => $val) { //Вывод новости
            $key = $_POST['id']; // Индекс новости = id
            if (isset($news[$key])) {
                $item = '<b>' . "Новость " . $key . ': </b>' . $news[$key] . '</br>';
            }

        }
        echo $item;

        if ($_POST['id'] > count($news)) {
            news_list($news);
        }
    } else {
        header("HTTP/1.0 404 Not Found");
    }
}
?>