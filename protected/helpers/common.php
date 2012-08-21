<?php
/**********************************************************************************************
*                            CMS Open Real Estate
*                              -----------------
*	version				:	1.3.1
*	copyright			:	(c) 2012 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Real Estate
*
* Open Real Estate is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Real Estate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/

function param($name, $default = null){
	if (isset(Yii::app()->params[$name]))
		return Yii::app()->params[$name];
	else
		return $default;
}

function tt($string, $module = null, $lang = '') {
	if ($module === null) {
		if (Yii::app()->controller->module) {
			return TranslateMessage::t($string, 'module_'.Yii::app()->controller->module->id);
		}
		return TranslateMessage::t($string);
	}
    if($module == TranslateMessage::DEFAULT_CATEGORY){
        return TranslateMessage::t($string, TranslateMessage::DEFAULT_CATEGORY);
    }
	return TranslateMessage::t($string, 'module_'.$module, $lang);
}

function tc($string){
    return TranslateMessage::t($string, 'common');
}

function isActive($string){
    $menu_active = Yii::app()->user->getState('menu_active');
    if( $menu_active == $string ){
        return true;
    } elseif( !$menu_active ){
        if(isset(Yii::app()->controller->module->id) && Yii::app()->controller->module->id == $string){
            return true;
        }
    }
    return false;
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		if($objects){
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						rrmdir($dir . "/" . $object);
					else
						unlink($dir . "/" . $object);
				}
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function issetModule($module) {
    if (is_array($module)) {
        foreach ($module as $module_name) {
            if (!isset(Yii::app()->modules[$module_name])) {
                return false;
            }
        }
        return true;
    }
    return isset(Yii::app()->modules[$module]);
}

function deb($mVal, $sName = '') {
	$aCol = array('#FFF082','#BAFF81','#BAFFD7','#F0D9D7');
	$color = $aCol[RAND(0,3)];
	echo "<div style='background-color: $color;'><PRE><strong>$sName = </strong>";
	if (is_array($mVal)) echo '<br>';
	print_r($mVal);
	echo "</PRE></div>";
}

function logs($mVal) {
	$file = fopen( ROOT_PATH . '/uploads/logs.txt', 'w+' );
	$sLogs = date( "d.m.y H:i : " ) . var_export($mVal, true) . "\n";
	fwrite($file, $sLogs);
	fclose($file);
}

function throw404(){
	throw new CHttpException(404,'The requested page does not exist.');
}

function showMessage($messageTitle, $messageText , $breadcrumb = '', $isEnd = true) {
	 Yii::app()->controller->render('//site/message', array('breadcrumb' => $breadcrumb,
					'messageTitle' => $messageTitle,
					'messageText'  => $messageText));

	 if ($isEnd) {
		Yii::app()->end();
	 }
}

function modelName() {
    return Yii::app()->controller->id;
}

function toBytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str) - 1]);
	switch ($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}
