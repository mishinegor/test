<?php

function validate_input($data_input) {
    $data_input = trim($data_input);
    $data_input = stripslashes($data_input);
    $data_input = htmlspecialchars($data_input);
    return $data_input;
}

function myLogger($db, $sql, $caller)
{
    // Находим контекст вызова этого запроса.
    $tip = "at ".@$caller['file'].' line '.@$caller['line'];
    // Печатаем запрос (конечно, Debug_HackerConsole лучше).
    echo "<xmp title=\"$tip\">";
    print_r($sql);
    echo "</xmp>";
}

function getCities($db) {
    $cities = array();
    $cities_result = $db->select('SELECT *  FROM cities') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
    foreach ($cities_result as $key => $val) {
        $cities[$val['id']] = $val['city_name'];
    }
    return $cities;
}

function getCategories($db) {
    $categories= array();
    $cat_result = $db->select('SELECT * FROM categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД ;
    foreach($cat_result as $key => $val) {
        $categories[$val['id']] = $val['category'];
    }
    return $categories;
}


function getAds($db) {
    $data=array();
    $data['ads'] = $db->select ("SELECT ads.id AS ARRAY_KEY, ads.type, ads.name, email, confirm_rss, phone,cities.id as city_id, categories.id as category_id, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)") or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
    return $data;
}



function insertItem($db, $validate_data) {
    $add_query = $db->query("INSERT INTO ads (TYPE, NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?d, ?d, ?, ?, ?d)",
    $validate_data['type'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city_id'], $validate_data['category_id'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price']);
    }
function delItem ($db, $id){
    $del_query = $db->query("DELETE FROM ads WHERE id = ?d", $id) or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
}

function updateItem($db, $validate_data, $id) {
    $update_query = $db->query("UPDATE  ads SET ID = ?d, TYPE=?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?d, CATEGORY = ?d, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?d",
    $id ,$validate_data['type'], $validate_data['name'], $validate_data['email'],  $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city_id'], $validate_data['category_id'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price'], $validate_data['id']);
}

 ?>
