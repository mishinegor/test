<?php

function validate_input($data_input) {
    $validate_data=array();
    foreach ($data_input as $key => $val) {
        $validate_data[$key] = trim($val);
        $validate_data[$key] = stripslashes($val);
        $validate_data[$key] = htmlspecialchars($val);
    }
    return $validate_data;
}

function validation_form($data_form){
    $validate_email = filter_var($data_form['email'], FILTER_VALIDATE_EMAIL);
    $validate_phone = filter_var($data_form['phone'], FILTER_VALIDATE_INT);
    $validate_price = filter_var($data_form['price'], FILTER_VALIDATE_INT);

    $result=array();
    $result['status'] = true;

    if (!isset($data_form['email']) || empty($data_form['email']) || !$validate_email){
        $result['status'] = false;
        $result['message'][] = 'Неправильно введён  email';
    }

    if (!isset($data_form['phone']) || empty($data_form['phone']) || !$validate_phone){
        $result['status'] = false;
        $result['message'][] = 'Неправильно введён номер телефона';
    }

    if (!isset($data_form['price']) || empty($data_form['price']) || !$validate_price){
        $result['status'] = false;
        $result['message'][] = 'Неправильно введёно поле цена';
    }
    return $result;
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

function getWarnings($db) {
    $warnings = array();
    $warnings_result = $db->select('SELECT *  FROM warnings') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
    foreach ($warnings_result as $key => $val) {
        $warnings[$val['id']] = $val['warning'];
    }
    return $warnings;
}

function getbusiness_type($db) {
    $business_type = array();
    $type_result = $db->select('SELECT *  FROM  business_type') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
    foreach ($type_result as $key => $val) {
        $business_type[$val['type']] = $val['type_value'];
    }
    return $business_type;
}

function getCheckbox($db) {
    $confirm_rss = array();
    $checkbox_result = $db->select('SELECT *  FROM  checkbox') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
    foreach ($checkbox_result as $key => $val) {
        $confirm_rss[$val['type']] = $val['value'];
    }
    return $confirm_rss;
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
    $data['ads'] = $db->select("SELECT ads.id AS ARRAY_KEY, ads.type, ads.name, email, confirm_rss, phone,cities.id as city_id, categories.id as category_id, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)");
    return $data;
}



function insertItem($db, $validate_data) {
    $add_query = $db->query("INSERT INTO ads (TYPE, NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES ( ?, ?, ?, ?, ?,  ?d, ?d, ?, ?, ?d)",
    $validate_data['type'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city'], $validate_data['cat'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price']);
    }
function delItem ($db, $id){
    $del_query = $db->query("DELETE FROM ads WHERE id = ?d", $id) or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
}

function updateItem($db, $validate_data, $id) {
    $update_query = $db->query("UPDATE  ads SET ID = ?d, TYPE=?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?d, CATEGORY = ?d, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?d",
    $id ,$validate_data['type'], $validate_data['name'], $validate_data['email'],  $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city'], $validate_data['category'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price'], $validate_data['id']);
}

 ?>
