<?php
namespace  rahulswt7\liveCurrencyWidget;

use Yii;

//use yii\base\Widget;

class CurrencyWidget extends \yii\base\Widget{
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        parent::run();
        
        return $this->render('currency');
        
    }
}
