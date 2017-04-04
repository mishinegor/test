<?php

class Ads
{
    protected $id;
    protected $type;
    protected $name;
    protected $email;
    protected $confirm_rss;
    protected $phone;
    protected $city;
    protected $category;
    protected $name_ad;
    protected $ad_text;
    protected $price;

   public function __construct($ad)
    {
        if (!empty($ad['id'])) {
            $this->id = $ad['id'];
        }

        $this->type = $ad['type'];
        $this->name = $ad['name'];
        $this->email = $ad['email'];
        $this->confirm_rss = $ad['confirm_rss'][0];
        $this->phone = $ad['phone'];
        $this->city = $ad['city'];
        $this->category = $ad['category'];
        $this->name_ad = $ad['name_ad'];
        $this->ad_text = $ad['ad_text'];
        $this->price = $ad['price'];
    }

    public function getId() {
        return $this->id;
}
    public function getType() {
        return $this->type;
    }
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getConfirm_rss() {
        return $this->confirm_rss;
    }
    public function getPhone() {
    return  filter_var($this->phone, FILTER_VALIDATE_INT);
}
    public function getCity() {
        return $this->city;
    }
    public function getCategory() {
        return $this->phone;
    }
    public function getNameAd() {
        return $this->name_ad;
    }
    public function getAdText() {
        return $this->ad_text;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getVars(){
        return get_object_vars($this);
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