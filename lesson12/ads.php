<?php

class Ads
{
    public $id;
    public $type;
    public $name;
    public $email;
    public $confirm_rss;
    public $phone;
    public $city;
    public $category;
    public $name_ad;
    public $ad_text;
    public $price;


    public function __construct($ad)
    {
        $validate_data = array();
        foreach ($ad as $key => $val) {
            $validate_data[$key] = trim($val);
            $validate_data[$key] = stripslashes($val);
            $validate_data[$key] = htmlspecialchars($val);
        }

        if (isset($validate_data['id'])) {
            $this->id = $validate_data['id'];
        }


        $this->type = $validate_data['type'];
        $this->name = $validate_data['name'];
        $this->email = filter_var($validate_data['email'], FILTER_VALIDATE_EMAIL);
        $this->confirm_rss = $validate_data['confirm_rss'][0];
        $this->phone = filter_var($validate_data['phone'], FILTER_VALIDATE_INT);
        $this->city = $validate_data['city'];
        $this->category = $validate_data['cat'];
        $this->name_ad = $validate_data['name_ad'];
        $this->ad_text = $validate_data['ad_text'];
        $this->price = filter_var($validate_data['price'], FILTER_VALIDATE_INT);

    }

    public function getWarnings() {
        $warnings = array();
        $warnings['status'] = true;



        if (!isset($this->phone) || empty($this->phone) || !$this->phone){
            $warnings['status'] = false;
            $warnings['message'][] = 'Неправильно введён номер телефона';
        }

        if (!isset($this->price) || empty($this->price) || !$this->price){
            $warnings['status'] = false;
            $warnings['message'][] = 'Неправильно введёно поле цена';
        }
        return $warnings;

    }

    public function insertItem($db) {
        $vars = get_object_vars($this);
        $add_query = $db->query("REPLACE INTO ads (?#) VALUES (?a)",
           array_keys($vars), array_values($vars));
    }

    public function delItem ($db){
        $this->id = filter_var($_GET['id'], FILTER_SANITIZE_URL);
        $del_query = $db->query("DELETE FROM ads WHERE id = ?d", $this->id) or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));
    }

}

class privateAd extends Ads
{
    public function getType(){
        return $this->type = 'private';
    }
}

class corpAd extends Ads
{
    public function getType(){
        return $this->type ='corp';
    }
}