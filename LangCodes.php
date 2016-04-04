<?php
/**
 * @author: Cesar Hernandez
 * getLanguage: This method return the name of the language according to the language code
 */
class LangCodes{
    public function getLanguage($code){
        $all_lang=array(
        'fr'=>'fr_FR',
        'en'=>'en_US'
        );
        return $all_lang[$code];
    }
    public function getNameLang($code_lang){
        $name_lang=array(
        'fr'=>'Français',
        'en'=>'English'
        );
        return $name_lang[$code_lang];
    }
}
?>