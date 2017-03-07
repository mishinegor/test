<?php

class Ad
{
    public $validate_data;
    public $validate_email;
    public $validate_phone;
    public $validate_price;
    public $id;
    public $warnings;



    public function validationForm($data_form){
        $this->validate_data=array();
        foreach ($data_form as $key => $val) {
            $this->validate_data[$key] = trim($val);
            $this->validate_data[$key] = stripslashes($val);
            $this->validate_data[$key] = htmlspecialchars($val);
        }
        $this->validate_email = filter_var($this->validate_data['email'], FILTER_VALIDATE_EMAIL);
        $this->validate_phone = filter_var($this->validate_data['phone'], FILTER_VALIDATE_INT);
        $this->validate_price = filter_var($this->validate_data['price'], FILTER_VALIDATE_INT);

        $this->warnings = array();
        $this->warnings['status'] = true;

        if (!isset($data_form['email']) || empty($data_form['email']) || !$this->validate_email){
            $this->warnings['status'] = false;
            $this->warnings['message'][] = 'Неправильно введён  email';
        }

        if (!isset($data_form['phone']) || empty($data_form['phone']) || !$this->validate_phone){
            $this->warnings['status'] = false;
            $this->warnings['message'][] = 'Неправильно введён номер телефона';
        }

        if (!isset($data_form['price']) || empty($data_form['price']) || !$this->validate_price){
            $this->warnings['status'] = false;
            $this->warnings['message'][] = 'Неправильно введёно поле цена';
        }
        return  $this->warnings;
    }
    public function insertItem($db) {
        $add_query = $db->query("INSERT INTO ads (TYPE, NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES ( ?, ?, ?, ?, ?,  ?d, ?d, ?, ?, ?d)",
            $this->validate_data['type'],  $this->validate_data['name'],  $this->validate_data['email'],  $this->validate_data['confirm_rss'],  $this->validate_data['phone'],  $this->validate_data['city'],  $this->validate_data['cat'], $this->validate_data['name_ad'],  $this->validate_data['ad_text'],  $this->validate_data['price']);
    }
    public function updateItem($db) {
        $this->id = filter_var($_GET['id'], FILTER_SANITIZE_URL);
    $update_query = $db->query("UPDATE  ads SET ID = ?d, TYPE=?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?d, CATEGORY = ?d, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?d",
        $this->id, $this->validate_data['type'], $this->validate_data['name'], $this->validate_data['email'],  $this->validate_data['confirm_rss'], $this->validate_data['phone'], $this->validate_data['city'], $this->validate_data['cat'], $this->validate_data['name_ad'], $this->validate_data['ad_text'], $this->validate_data['price'], $this->validate_data['id']);
}

}