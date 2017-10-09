<?php

namespace Stringy\Inflections;

/**
 * Norwegian Bokmal inflection rules.
 */
class Nb extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/e$/i' => 'er',
            '/r$/i' => 're',
            '/$/' => 'er',
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
            '/re$/i' => 'r',
            '/er$/i' => '',
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
            'konto' => 'konti',
        ];
    }

    /**
     * Return an array of uncountable rules (sheep, police)
     *
     * @return array
     */
    public function uncountableRules()
    {
        return [
            'barn',
            'fjell',
            'hus',
        ];
    }
}
