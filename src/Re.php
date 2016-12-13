<?php
/**
 * Created by PhpStorm.
 * User: 方剑成
 * Date: 2016/12/13
 * Time: 11:30
 */

namespace Funch;


class Re {
    public $rPattern = '';
    public $rDelimiter = '`';
    public $rModifier = '';

    public $rSubject = '';

    static function pattern ($pattern = null, $modifier = '') {
        return new self($pattern, $modifier);
    }

    function delimiter ($delimiter) {
        $this->rDelimiter = $delimiter;
        $this->rPattern = $this->generatePattern($this->rPatternSrc);
        return $this;
    }
    function modifier ($modifier) {
        $this->rModifier = $modifier;
        $this->rPattern = $this->generatePattern($this->rPatternSrc);
        return $this;
    }
    public function subject ($subject) {
        $this->rSubject = $subject;
        return $this;
    }

    function __construct ($pattern, $modifier = '') {
        $this->rModifier = $modifier;
        $this->rPatternSrc = $pattern;
        $this->rPattern = $this->generatePattern($pattern);
    }

    function generatePattern ($pattern) {
        return is_array($pattern) ? $pattern : (
            $this->rDelimiter.
            str_replace($this->rDelimiter, '\\'.$this->rDelimiter, $pattern).
            $this->rDelimiter.
            $this->rModifier
        );
    }

    function match () {
        if (
        !preg_match(
            is_array($this->rPattern) ? $this->rPattern[0] : $this->rPattern,
            $this->rSubject,
            $matches
        )
        ) return [];
        return $matches;
    }

    function matchAll ($flags = PREG_SET_ORDER) {
        if (
        !preg_match_all(
            is_array($this->rPattern) ? $this->rPattern[0] : $this->rPattern,
            $this->rSubject,
            $matches,
            $flags
        )
        ) return [];
        return $matches;
    }

    function replace ($replacement, $pattern = null, $subject = null) {
        if (is_callable($replacement)) {
            return preg_replace_callback(
                $pattern ?: $this->rPattern,
                $replacement,
                $subject ?: $this->rSubject
            );
        } elseif (is_array($replacement)) {
            $t = $this->rSubject;
            foreach ($replacement as $i => $r) {
                $t = $this->replace(
                    $r,
                    is_null($this->rPatternSrc) ? $i : (is_array($this->rPattern) ? $this->rPattern[$i] : $this->rPattern),
                    $t
                );
            }
            return $t;
        } else {
            return preg_replace(
                $pattern ?: $this->rPattern,
                $replacement,
                $subject ?: $this->rSubject
            );
        }
    }

    function __toString () {
        return print_r($this->rPattern, true);
    }
}