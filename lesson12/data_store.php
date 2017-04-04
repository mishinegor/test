<?php


class DataStore
{
    private static $instance = NULL;
    protected $cities;
    protected $business_type;
    protected $confirm_rss;
    protected $categories;
    protected $warnings;
    protected $show_param;

    public static function instance() {
        if(self::$instance==NULL) {
            self::$instance= new DataStore();
        }
        return self::$instance;
    }
    public function getWarnings() {
        $ad = $_POST;
        $this->warnings = array();
         $this->warnings['status'] = true;

        $validate_email = filter_var($ad['email'], FILTER_VALIDATE_EMAIL);
        $validate_phone = filter_var($ad['phone'], FILTER_VALIDATE_INT);
        $validate_price = filter_var($ad['price'], FILTER_VALIDATE_INT);

        if (empty($validate_email) || !($validate_email)){
             $this->warnings['status'] = false;
             $this->warnings['message'][] = 'Неправильно введён email';
        }

        if (empty($validate_phone) || !($validate_phone)){
             $this->warnings['status'] = false;
             $this->warnings['message'][] = 'Неправильно введён email';
        }

        if (empty($validate_price) || !($validate_price)){
             $this->warnings['status'] = false;
             $this->warnings['message'][] = 'Неправильно введёно поле цена';
        }

        return  $this->warnings;

    }
    public function getWarningsMassages() {
        global $smarty;
        $smarty->assign('alert',  $this->warnings['message']);
    }
    public function getCities() {
        global $db;
        $this->cities = array();
        $cities_result = $db->select('SELECT *  FROM cities') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($cities_result as $key => $val) {
            $this->cities[$val['id']] = $val['city_name'];
        }
        return $this->cities;
    }
    public function showAd(AdsStore $ads)   {
        global $smarty;
        if (isset($this->show_param)) {
            $show_ad = $ads->ads[$this->show_param];
        } else {
            $show_ad =$_POST;
        }
        $smarty->assign('ad', $show_ad);

    }
    public function getShowParam() {
        $this->show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
        return $this->show_param;
    }
    public function getBusinessType() {
        global $db;
        $this->business_type = array();
        $type_result = $db->select('SELECT *  FROM  business_type') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($type_result as $key => $val) {
            $this->business_type[$val['type']] = $val['type_value'];
        }
        return $this->business_type;
    }
    public function getCheckbox() {
        global $db;
        $this->confirm_rss = array();
        $checkbox_result = $db->select('SELECT *  FROM  checkbox') or die("Невозвожно выполнить запрос, код ошибки :" . mysqli_error($db));// вывод городов из БД;
        foreach ($checkbox_result as $key => $val) {
            $this->confirm_rss[$val['type']] = $val['value'];
        }
        return $this->confirm_rss;
    }
    public function getCategories() {
        global $db;
        $this->categories= array();
        $cat_result = $db->select('SELECT * FROM categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД ;
        foreach($cat_result as $key => $val) {
            $this->categories[$val['id']] = $val['category'];
        }
        return $this->categories;
    }
    public function getButtonValue(){
        if (isset($_GET['show'])) {
            $button_value = "Сохранить объявление";
        } else {
            $button_value = "Добавить объявление";
        }
        return $button_value;
    }
    public function writeDataStore($data_store){
        global $smarty;
        $smarty->assign('data_store', $data_store);
    }

}