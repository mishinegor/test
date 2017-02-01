<?php
// Запмсь в файл
error_reporting( E_ERROR );

include('functions.php');

$show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
$id = filter_var($_GET['id'], FILTER_SANITIZE_URL);

$button_value="Добавить объявление";

// Соединение с базой данных
    $db = mysqli_connect(
        'localhost',
        'root',
        '',
        'ads_base'
    ) or die("Невозвожно подключиться к базе данных, код ошибки:".mysqli_connect_error());

    mysqli_set_charset($db, 'utf8');


    $result_cities = mysqli_query($db, 'select * from cities') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));// вывод городов из БД
    while($row_cities = mysqli_fetch_assoc($result_cities)){
        $cities[$row_cities['id']]= $row_cities['city_name'];
    }

    $result_cat = mysqli_query($db, 'select * from categories'); // вывод категорий из БД
    while($row_cat = mysqli_fetch_assoc($result_cat)){
        $categories[$row_cat['id']]= $row_cat['category'];
    }

    $extract_sql = "SELECT ads.id, sellers.name, email, confirm_rss, phone, city_name, categories.category, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)";

    $result_data = mysqli_query($db,  $extract_sql); // вывод обявлений из БД
    while($row_data = mysqli_fetch_assoc($result_data)){
        $data['ads'][$row_data['id']]=$row_data;
    }

if(isset($_POST['add'])) { // Добавление записи
    if(isset($_GET['del'])){
        unset($_GET['del']);
    }

    if(isset($_GET['show']) && isset($data['ads'][$_POST['id']])){
        $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
        $data['ads'][$_POST['id']] = $edition_ad;
        header('location: dz_7_2.php');

    } else {
        $data['ads'][]=$_POST;
    }
}
if (isset($_GET['show'])){
    $button_value="Сохранить объявление";
}

if (isset($_GET['del']) && isset($data['ads'][$_GET['id']])) { //Удаление записи
    unset($data['ads'][$_GET['id']]);
}

// массив select cities


// массив select categories


//Массив переменных
$var_array =[
    'name' => get_item($data['ads'][$id]['name']),
    'email' => get_item($data['ads'][$id]['email']),
    'radio_private' => get_result($data['ads'][$id]['private'], $show_param),
    'radio_corp' => get_result($data['ads'][$id]['corp'], $show_param),
    'checkbox_confirm' => get_result($data['ads'][$id]['confirm_rss'], $show_param),
    'phone' => get_item($data['ads'][$id]['phone']),
    'city_id' => select_option($cities, $data['ads'][$id]['city']),
    'cat_id' => select_option($cities, $data['ads'][$id]['cat']),
    'name_ad' =>  get_item($data['ads'][$id]['name_ad']),
    'ad_text' =>  get_item($data['ads'][$id]['ad']),
    'price' => get_item($data['ads'][$id]['price']),
    'show_param' => $show_param,
    'button_value' => $button_value
];

// SMARTY

    $project_root = $_SERVER['DOCUMENT_ROOT'];
    $smarty_dir = $project_root. '/smarty/';

    // put full path to Smarty.class.php
    require( $smarty_dir.'libs/Smarty.class.php');

    $smarty = new Smarty();
    $smarty->compile_check = true;
    $smarty->debugging = true;

    $smarty->template_dir = $smarty_dir.'templates';
    $smarty->compile_dir = $smarty_dir.'templates_c';
    $smarty->cache_dir = $smarty_dir.'cache';
    $smarty->config_dir = $smarty_dir.'configs';


    $smarty->assign('ads', $data['ads']);
    $smarty->assign('cat', $categories);
    $smarty->assign('cities', $cities);
    $smarty->assign('var_array', $var_array);



    $smarty->display('index.tpl');
?>