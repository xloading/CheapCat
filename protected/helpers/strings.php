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

function truncateText($text, $numOfWords = 10, $add = ''){
	if($numOfWords){
		$text = strip_tags($text, '<br/>');
		$text = str_replace(array("\r", "\n"), '', $text);

		$lenBefore = strlen($text);
		if($numOfWords){
			if(preg_match("/\s*(\S+\s*){0,$numOfWords}/", $text, $match)){
				$text = trim($match[0]);
			}
			if(strlen($text) != $lenBefore){
				$text .= '.. '.$add;
			}
		}
	}

	return $text;
}

function utf8_substr($str, $from, $len) {
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
	'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
	'$1',$str);
}

function utf8_strlen($s) {
	return preg_match_all('/./u', $s, $tmp);
}

function utf8_ucfirst($string, $e ='utf-8') { 
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) { 
        $string = mb_strtolower($string, $e); 
        $upper = mb_strtoupper($string, $e); 
            preg_match('#(.)#us', $upper, $matches); 
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
    } 
    else { 
        $string = ucfirst($string); 
    } 
    return $string; 
}  