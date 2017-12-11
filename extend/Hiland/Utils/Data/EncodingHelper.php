<?php
/**
 * Created by PhpStorm.
 * User: xiedali
 * Date: 2017/12/11
 * Time: 14:12
 */

namespace Hiland\Utils\Data;


class EncodingHelper
{
    const ASCII= "ASCII";
    const GB2312= "GB2312";
    const GBK= "GBK";
    const UTF8= "UTF-8";

    public static function getCodingName($data)
    {
        $ary[] = self::ASCII;
        $ary[] = self::GB2312;
        $ary[] = self::GBK;
        $ary[] = self::UTF8;
        $encodingName = mb_detect_encoding($data, $ary);
        return $encodingName;
    }

    /**
     *
     * @param $string the string want to be escaped
     * @param $in_encoding
     * @param $out_encoding
     */

    /**js的escape方法在php中的实现
     * @param $string
     * @param string $in_encoding
     * @param string $out_encoding
     * @return string
     */
    public static function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') {
        $return = '';
        if (function_exists('mb_get_info')) {
            for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) {
                $str = mb_substr ( $string, $x, 1, $in_encoding );
                if (strlen ( $str ) > 1) { // 多字节字符
                    $return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) );
                } else {
                    $return .= '%' . strtoupper ( bin2hex ( $str ) );
                }
            }
        }
        return $return;
    }

    /**js的escape方法在php中的解码
     * @param $data
     * @return string
     */
    public static function unescape($data)
    {
        $ret = '';
        $len = strlen($data);
        for ($i = 0; $i < $len; $i ++)
        {
            if ($data[$i] == '%' && $data[$i + 1] == 'u')
            {
                $val = hexdec(substr($data, $i + 2, 4));
                if ($val < 0x7f)
                    $ret .= chr($val);
                else
                    if ($val < 0x800)
                        $ret .= chr(0xc0 | ($val >> 6)) .
                            chr(0x80 | ($val & 0x3f));
                    else
                        $ret .= chr(0xe0 | ($val >> 12)) .
                            chr(0x80 | (($val >> 6) & 0x3f)) .
                            chr(0x80 | ($val & 0x3f));
                $i += 5;
            } else
                if ($data[$i] == '%')
                {
                    $ret .= urldecode(substr($data, $i, 3));
                    $i += 2;
                } else
                    $ret .= $data[$i];
        }
        return $ret;
    }

}
