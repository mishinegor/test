<?php

function validate_input($data_input) {
    $data_input = trim($data_input);
    $data_input = stripslashes($data_input);
    $data_input = htmlspecialchars($data_input);
    return $data_input;
}

function getCities($db) {
    global $cities;
    $cities_query = mysqli_query($db, 'select * from cities') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));// вывод городов из БД
    $cities_result = mysqli_fetch_all($cities_query, MYSQLI_ASSOC);
    foreach($cities_result as $key => $val) {
        $cities[$val['id']] = $val['city_name'];
    }
}

function getCategories($db) {
    global $categories;
    $cat_query = mysqli_query($db, 'select * from categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД
    $cat_result = mysqli_fetch_all($cat_query, MYSQLI_ASSOC);
    foreach($cat_result as $key => $val) {
        $categories[$val['id']] = $val['category'];
    }
}

function getAds($db) {
    $extract_sql = "SELECT ads.id, ads.name, email, confirm_rss, phone, city_name, categories.category, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)";
    global $data;
    $data_query = mysqli_query($db,  $extract_sql); // вывод обявлений из БД
    $data_result = mysqli_fetch_all($data_query, MYSQLI_ASSOC);
    foreach ($data_result as $key => $val) {
        $data['ads'][$val['id']]=$val;
    }
}

function insertItem($db, $validate_data) {
    $add_query = mysqli_prepare($db, "INSERT INTO ads ( TYPE , NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($add_query, 'sssssiissi', $validate_data['type'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'],$validate_data['city'], $validate_data['cat'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price']);
    mysqli_stmt_execute($add_query);
}

function delItem ($db, $id){
    $del_query = mysqli_prepare($db, "DELETE FROM ads WHERE id = ?");
    mysqli_stmt_bind_param($del_query, 'i', $id);
    mysqli_stmt_execute($del_query);
}

function updateItem($db, $validate_data, $id) {
    $update_query = mysqli_prepare($db, "UPDATE  ads SET ID = ?, TYPE = ?,  NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?, CATEGORY = ?, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?");
    mysqli_stmt_bind_param($update_query, 'isssssiissii', $id ,$validate_data['type'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city'], $validate_data['cat'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price'], $validate_data['id']);
    mysqli_stmt_execute($update_query);
}
 ?>
