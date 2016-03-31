<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
/**
 * Description of TestForm
 *
 * @author IVNovoselov
 */
class TestForm extends Model{
    public $name;
    public $email;
    public $file;


    public function rules() {
        return [
            // name, email- обязательны
            [['name', 'email'], 'required','message'=>'Обязательные поля'],
            // email has to be a valid email address
            ['email', 'email','message'=>'Не корректный адрес'],
            ['file', 'file', 'extensions' => ['png']]
        ];
    }
    
}
