<?php
/**
 * Created by PhpStorm.
 * User: rok
 * Date: 2018. 6. 13.
 * Time: PM 3:59
 */

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class SearchController
{
    public function index(Request $request){
        $keyword = $request['keyword'];
        $boards = Board::search()->queryString($keyword, ["default_field" => "title"])->get();
        print($boards->hits());
    }

    function utf8_strlen($str) { return mb_strlen($str, 'UTF-8'); }
    function utf8_charAt($str, $num) { return mb_substr($str, $num, 1, 'UTF-8'); }
    function utf8_ord($ch) {
        $len = strlen($ch);
        if($len <= 0) return false;
        $h = ord($ch{0});
        if ($h <= 0x7F) return $h;
        if ($h < 0xC2) return false;
        if ($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
        if ($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);
        if ($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
        return false;
    }

    function linear_hangul($str) {
        $cho = [ "ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ" ];
        $jung = [ "ㅏ","ㅐ","ㅑ","ㅒ","ㅓ","ㅔ","ㅕ","ㅖ","ㅗ","ㅘ","ㅙ","ㅚ","ㅛ","ㅜ","ㅝ","ㅞ","ㅟ","ㅠ","ㅡ","ㅢ","ㅣ" ];
        $jong = [ "","ㄱ","ㄲ","ㄳ","ㄴ","ㄵ","ㄶ","ㄷ","ㄹ","ㄺ","ㄻ","ㄼ","ㄽ","ㄾ","ㄿ","ㅀ","ㅁ","ㅂ","ㅄ","ㅅ","ㅆ","ㅇ","ㅈ","ㅊ","ㅋ"," ㅌ","ㅍ","ㅎ" ];
        $result = "";

        for ($i=0; $i<$this->utf8_strlen($str); $i++) {
            $code = $this->utf8_ord($this->utf8_charAt($str, $i)) - 44032;
            if ($code > -1 && $code < 11172) {
                $cho_idx = $code / 588;
                $jung_idx = $code % 588 / 28;
                $jong_idx = $code % 28;
                $result .= $cho[$cho_idx].$jung[$jung_idx].$jong[$jong_idx];
            } else {
                $result .= $this->utf8_charAt($str, $i);
            }
        }
        return $result;
    }
}