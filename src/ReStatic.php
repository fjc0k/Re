<?php
/**
 * Created by PhpStorm.
 * User: 方剑成
 * Date: 2016/12/13
 * Time: 11:51
 */

namespace Funch;


class ReStatic
{
    public static function pattern ($pattern = null, $modifier = '') {
        return Re::pattern($pattern, $modifier);
    }
    public static function subject ($subject) {
        return Re::pattern(null)->subject($subject);
    }
}