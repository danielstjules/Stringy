<?php

namespace Stringy\Inflections;

use Stringy\Stringy;

abstract class Inflector
{
    protected static $pluralCache = [];

    protected static $singularCache = [];

    public function pluralize(Stringy $str)
    {
        if (array_key_exists($str->toLowerCase(), self::$pluralCache)) {
            return self::$pluralCache[(string)$str->toLowerCase()];
        }

        if (!$this->isCountable($str)) {
            return $str;
        }

        if (array_key_exists($str->toLowerCase(), $this->irregularRules())) {
            return $this->irregularRules()[(string)$str->toLowerCase()];
        }

        foreach ($this->pluralRules() as $rule => $replacement) {
            if (preg_match($rule, $str)) {
                return self::$pluralCache[(string)$str->toLowerCase()] = preg_replace($rule, $replacement, $str);
            }
        }
    }

    public function singularize(Stringy $str)
    {
        if (array_key_exists($str->toLowerCase(), self::$singularCache)) {
            return self::$singularCache[(string)$str->toLowerCase()];
        }

        if (!$this->isCountable($str)) {
            return $str;
        }

        if (array_key_exists($str->toLowerCase(), array_flip($this->irregularRules()))) {
            return array_flip($this->irregularRules())[(string)$str->toLowerCase()];
        }

        foreach ($this->singularRules() as $rule => $replacement) {
            if (preg_match($rule, $str)) {
                return self::$singularCache[(string)$str->toLowerCase()] = preg_replace($rule, $replacement, $str);
            }
        }
    }

    /**
     * @param Stringy $str
     *
     * @return bool
     */
    public function isCountable(Stringy $str)
    {
        return !array_key_exists($str->toLowerCase(), $this->uncountableRules());
    }

    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    abstract public function pluralRules();

    /**
     * Return an array of singularization rules, from most to least specific, in the form $rule => $replacement
     *
     *
     * @return array
     */
    abstract public function singularRules();

    /**
     * Return an array of irregular replacements, in the form singular => plural ('goose' => 'geese')
     *
     * @return array
     */
    abstract public function irregularRules();

    /**
     * Return an array of uncountable rules (sheep, police)
     *
     * @return array
     */
    abstract public function uncountableRules();
}