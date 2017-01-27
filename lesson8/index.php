<?php
      // Запмсь в файл
        error_reporting( E_ERROR );


    include('functions.php');
    global $data;
    global $data_temp;
    $data_temp=array();

    $show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_URL);

    $button_value="Добавить объявление";

    if(isset($_POST['add'])) { // Добавление записи
        if(isset($data_temp)) {
            $data_temp = file_get_contents('test.html');
            $data = unserialize($data_temp);
        }

        unset($_GET['del']);

        if(isset($_GET['show']) && isset($data['ads'][$_POST['id']])){
            $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
            $data['ads'][$_POST['id']] = $edition_ad;
            header('location:index.php');// чистим url строку
            $string_data = serialize($data);
            file_put_contents('test.html', $string_data);
        } else {
            $data['ads'][]=$_POST;
        }
        $string_data = serialize($data);
        file_put_contents('test.html', $string_data);
    } else {
        if (isset($_GET['show'])){
            $button_value="Сохранить объявление";
        }
    }

    $data_temp = file_get_contents('test.html');
    $data = unserialize($data_temp);

    if (isset($_GET['del']) && isset($data['ads'][$_GET['id']])) { //Удаление записи
        unset($data['ads'][$_GET['id']]);
        $string_data = serialize($data);
        file_put_contents('test.html', $string_data);
        $data_temp = file_get_contents('test.html');
        $data = unserialize($data_temp);
    }

    // массив select cities
    $cities=[
        '543644'=>'Новосибирск',
        '543645'=>'Москва',
        '543646'=>'Минск'
    ];

    // массив select categories

    $categories=[
        '543655'=>'Бытовая техника',
        '543659'=>'Товары для дома',
        '543660'=>'Коампьютерная техника'
    ];

    $radio_private = get_result($data['ads'][$id]['private'], $show_param);
    $radio_corp = get_result($data['ads'][$id]['corp'], $show_param);
    $name = get_item($data['ads'][$id]['name']);
    $email = get_item($data['ads'][$id]['email']);
    $phone = get_item($data['ads'][$id]['phone']);
    $checkbox_confirm = get_result($data['ads'][$id]['confirm_rss'], $show_param);
    $ad_name = get_item($data['ads'][$id]['name_ad']);
    $city_id = select_option($cities, $data['ads'][$id]['city']);
    $cat_id = select_option($categories, $data['ads'][$id]['cat']);
    $ad_text = get_item($data['ads'][$id]['ad']);
    $price = get_item($data['ads'][$id]['price']);


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



    $smarty->assign('show_param', $show_param);

    $smarty->assign('ads', $data['ads']);
    $smarty->assign('button_value', $button_value);
    $smarty->assign('radio_private', $radio_private);
    $smarty->assign('radio_corp', $radio_corp);
    $smarty->assign('name', $name);
    $smarty->assign('email', $email);
    $smarty->assign('phone', $phone);
    $smarty->assign('checkbox_confirm', $checkbox_confirm);
    $smarty->assign('checkbox_confirm', $checkbox_confirm);
    $smarty->assign('cities', $cities);
    $smarty->assign('city_id', $city_id);
    $smarty->assign('cat', $categories);
    $smarty->assign('cat_id', $cat_id);
    $smarty->assign('ad_name', $ad_name);
    $smarty->assign('ad_text', $ad_text);
    $smarty->assign('price', $price);


    $smarty->display('index.tpl');
?>