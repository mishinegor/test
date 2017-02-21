<?php

function validate_input($data_input) {
    $data_input = trim($data_input);
    $data_input = stripslashes($data_input);
    $data_input = htmlspecialchars($data_input);
    return $data_input;
}

function getCities($db) {
    $cities=array();
    $cities_query = mysqli_query($db, 'select * from cities') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));// вывод городов из БД
    while ($row_cities = mysqli_fetch_assoc($cities_query)) {
        $row_cities = mysqli_fetch_assoc($cities_query);
        $cities[$row_cities['id']] = $row_cities['city_name'];
    }
    return $cities;
}

function getCategories($db) {
    $categories= array();
    $cat_query = mysqli_query($db, 'select * from categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД
    while ($row_cat = mysqli_fetch_assoc($cat_query)) {
        $row_cat = mysqli_fetch_assoc($cat_query);
        $categories[$row_cat['id']] = $row_cat['category'];
    }
    return $categories;
}

function getAds($db) {
    $data=array();
    $extract_sql = "SELECT ads.id, ads.type, ads.name, email, confirm_rss, phone, city_name, categories.category, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)";
if ($result = mysqli_query($db, $extract_sql)) {
    while ($data_result = mysqli_fetch_assoc($result)) {
        $data['ads'][$data_result['id']] = $data_result;
    }
}
    return $data;

}

function insertItem($db, $validate_data) {
    $add_query = mysqli_prepare($db, "INSERT INTO ads ( TYPE , NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
    mysqli_stmt_bind_param($add_query, 'sssssiissi', $validate_data['type'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'],$validate_data['city'], $validate_data['cat'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price']);
    if($add_query) {
        mysqli_stmt_execute($add_query);
    } else {
        die("Не удадлось добавить объявление");
    }

}

function delItem ($db, $id){
    $del_query = mysqli_prepare($db, "DELETE FROM ads WHERE id = ?") or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
    mysqli_stmt_bind_param($del_query, 'i', $id);
    if ($del_query) {
        mysqli_stmt_execute($del_query);
    } else {
        die("Не удадлось удалить объявление");
    }

}

function updateItem($db, $validate_data, $id) {
    $update_query = mysqli_prepare($db, "UPDATE  ads SET ID = ?, TYPE = ?,  NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?, CATEGORY = ?, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?") or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД;
    mysqli_stmt_bind_param($update_query, 'isssssiissii', $id ,$validate_data['type'], $validate_data['name'], $validate_data['email'],  $validate_data['confirm_rss'], $validate_data['phone'], $validate_data['city'], $validate_data['cat'], $validate_data['name_ad'], $validate_data['ad_text'], $validate_data['price'], $validate_data['id']);
    if($update_query) {
        mysqli_stmt_execute($update_query);
    } else {
        die("Не удадлось добавить объявление");
    }

}
 ?>
