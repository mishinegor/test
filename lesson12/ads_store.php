<?php

class AdsStore
{
    private static $instance = NULL;
    public $ads = array();
    protected $validate_data = array();




    public static function instance() {
        if(self::$instance==NULL) {
            self::$instance = new AdsStore();
        }
        return self::$instance;
    }
    public function insertItem($db, Ads $ad) {
        $vars = $ad->getVars();

        foreach ($vars as $key => $val) {
            $this->validate_data[$key] = trim($val);
            $this->validate_data[$key] = stripslashes($val);
            $this->validate_data[$key] = htmlspecialchars($val);
        }

        $add_query = $db->query('REPLACE INTO ads (?#) VALUES (?a)',
         array_keys($this->validate_data), array_values($this->validate_data));
    }
    public function addAds (Ads $ad) {
        if (!($this instanceof AdsStore)) {
            die ('Нельзя использовать этот метод');
        }

        $this->ads[$ad->getId()] = $ad;
    }
    public function delItem ($db){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_URL);
        $del_query = $db->query("DELETE FROM ads WHERE id = ?d", $id) or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));
        unset($this->ads[$id]);
    }
    public function writeAds (){
       global $smarty;
       $smarty->assign('ads', $this->ads);
    }
    public function getAds($db) {
        $data = $db->select("SELECT ads.id, ads.type, ads.name, email, confirm_rss, phone,cities.id as city_id, categories.id as category_id, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)");
        foreach ($data as $value) {
            $ad = new Ads($value);
            self::addAds($ad);
        }
    }
}
?>