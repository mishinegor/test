<?php


class DataStore extends Ads
{

    private static $instance = NULL;

    public  $data;
    public $id;
    public $show_param;
    public $ad;
    public $cities;
    public $business_type;
    public $confirm_rss;
    public $categories;

    public static function instance() {
        if(self::$instance==NULL) {
            self::$instance= new DataStore();
        }
        return self::$instance;
    }
    public function getCities($db) {
        $this->cities = array();
        $cities_result = $db->select('SELECT *  FROM cities') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($cities_result as $key => $val) {
            $this->cities[$val['id']] = $val['city_name'];
        }
        return $this->cities;
    }

    public function getBusinessType($db) {
        $this->business_type = array();
        $type_result = $db->select('SELECT *  FROM  business_type') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($type_result as $key => $val) {
            $this->business_type[$val['type']] = $val['type_value'];
        }
        return $this->business_type;
    }
    public function getCheckbox($db) {
        $this->confirm_rss = array();
        $checkbox_result = $db->select('SELECT *  FROM  checkbox') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($checkbox_result as $key => $val) {
            $this->confirm_rss[$val['type']] = $val['value'];
        }
        return $this->confirm_rss;
    }
    public function getCategories($db) {
        $this->categories= array();
        $cat_result = $db->select('SELECT * FROM categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД ;
        foreach($cat_result as $key => $val) {
            $this->categories[$val['id']] = $val['category'];
        }
        return $this->categories;
    }
    public function getAds($db) {
        if (!($this instanceof DataStore)) {
            die("Нельзя использовать этот метод");
        }
       // $this->data[$new_ad->getId()] = $new_ad;
        $this->data=array();
        $this->data['ads'] = $db->select("SELECT ads.id AS ARRAY_KEY, ads.type, ads.name, email, confirm_rss, phone,cities.id as city_id, categories.id as category_id, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)");
        return $this->data;
    }
    public function getButtonValue(){
        if (isset($_GET['show'])) {
            $button_value = "Сохранить объявление";
        } else {
            $button_value = "Добавить объявление";
        }
        return $button_value;
    }
    public function getShowparam() {
        $this->show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
        return $this->show_param;
    }
}