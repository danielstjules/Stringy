<?php

namespace Stringy\Inflections;

/**
 * Turkish inflection rules.
 */
class Tr extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/([eöiü][^aoıueöiü]{0,6})$/u' => '\1ler',
            '/([aoıu][^aoıueöiü]{0,6})$/u' => '\1lar',
        ];
    }

    /**
     * Return an array of singularization rules, from most to least specific, in the form $rule => $replacement
     *
     *
     * @return array
     */
    public function singularRules()
    {
        return [
            '/l[ae]r$/i' => '',
        ];
    }

    /**
     * Return an array of irregular replacements, in the form singular => plural ('goose' => 'geese')
     *
     * @return array
     */
    public function irregularRules()
    {
        return [
            'ben' => 'biz',
            'sen' => 'siz',
            'o'   => 'onlar',
        ];
    }

    /**
     * Return an array of uncountable rules (sheep, police)
     *
     * @return array
     */
    public function uncountableRules()
    {
        return [];
    }
}
