<?php
namespace APLite\Utility;

use APLite\AP;
use APLite\Exceptions\NotImplementedException;

/**
 * 数据编、解码工具类。
 *
 * @package       APLite\Utility
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class Enc {
    /**
     * 数据编码。
     *
     * @param mixed $data   需要编码的数据对象。
     * @param int   $format 指定编码方式。(注: 务必使用 Gac::ENC_* 常量定义.)
     * @param int   $opt    可选参数。
     * @return string
     * @throws NotImplementedException
     */
    static function encode($data, $format = AP::ENC_DEFAULTS, $opt = 320) {
        switch ($format) {
            case AP::ENC_JSON:
                return json_encode($data, $opt);
            case AP::ENC_MSGPACK:
                return \msgpack_serialize($data);
            case AP::ENC_IGBINARY:
                return \igbinary_serialize($data);
            default:
                throw new NotImplementedException('未定义的编码格式。');
        }
    }

    /**
     * 数据解码。
     *
     * @param string $data   需要解码的字符串数据。
     * @param int    $format 指定解码方式。(注: 务必使用 Gac::ENC_* 常量定义.)
     * @return mixed
     * @throws NotImplementedException
     */
    static function decode($data, $format = AP::ENC_DEFAULTS) {
        switch ($format) {
            case AP::ENC_JSON:
                return json_decode($data, true);
            case AP::ENC_MSGPACK:
                return \msgpack_unserialize($data);
            case AP::ENC_IGBINARY:
                return \igbinary_unserialize($data);
            default:
                throw new NotImplementedException('未定义的解码格式。');
        }
    }

    /**
     * Yar Response 数据编码。
     *
     * @param array|int|float|string $data
     * @param int                    $errno
     * @param string                 $errstr
     * @return string
     */
    static function encodeYarResponse($data = NULL, $errno = 0, $errstr = NULL) {
        $d_body = array(
            'i' => 0, //transaction id
            's' => $errno == 0 ? 500 : $errno, //状态码
            'r' => 2, //返回值
            'o' => $data, //直接输出值
            'e' => $errstr, //错误信息
        );
        $s_body = \msgpack_serialize($d_body);

        $header = pack('I1S1I1I1C32C32I1', 123456789, 0, 1626136448, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', strlen($s_body));

        $packager_pack = pack('a8', "msgpack");

        return $header . $packager_pack . $s_body;
    }
}