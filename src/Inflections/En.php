<?php

namespace Stringy\Inflections;

/**
 * English inflection rules.
 */
class En extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/(quiz)$/i'                           => '\1zes',
            '/^(oxen)$/i'                          => '\1',
            '/^(ox)$/i'                            => '\1en',
            '/^(m|l)ice$/i'                        => '\1ice',
            '/^(m|l)ouse$/i'                       => '\1ice',
            '/(matr|vert|ind)(?:ix|ex)$/i'         => '\1ices',
            '/(x|ch|ss|sh)$/i'                     => '\1es',
            '/([^aeiouy]|qu)y$/i'                  => '\1ies',
            '/(hive)$/i'                           => '\1s',
            '/(?:([^f])fe|([lr])f)$/i'             => '\1\2ves',
            '/sis$/i'                              => 'ses',
            '/([ti])a$/i'                          => '\1a',
            '/([ti])um$/i'                         => '\1a',
            '/(buffal|tomat|potat|volcan|her)o$/i' => '\1oes',
            '/(bu)s$/i'                            => '\1ses',
            '/(alias|status)$/i'                   => '\1es',
            '/^(ax|test)is$/i'                     => '\1es',
            '/s$/i'                                => 's',
            '/$/'                                  => 's',
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
            '/(database)s$/i'                                                        => '\1',
            '/(quiz)zes$/i'                                                          => '\1',
            '/(matr)ices$/i'                                                         => '\1ix',
            '/(vert|ind)ices$/i'                                                     => '\1ex',
            '/^(ox)en/i'                                                             => '\1',
            '/(alias|status)(es)?$/i'                                                => '\1',
            '/^(a)x[ie]s$/i'                                                         => '\1xis',
            '/(cris|test)(is|es)$/i'                                                 => '\1is',
            '/(shoe)s$/i'                                                            => '\1',
            '/(o)es$/i'                                                              => '\1',
            '/(bus)(es)?$/i'                                                         => '\1',
            '/^(m|l)ice$/i'                                                          => '\1ouse',
            '/(x|ch|ss|sh)es$/i'                                                     => '\1',
            '/(m)ovies$/i'                                                           => '\1ovie',
            '/(s)eries$/i'                                                           => '\1eries',
            '/([^aeiouy]|qu)ies$/i'                                                  => '\1y',
            '/([lr])ves$/i'                                                          => '\1f',
            '/(tive)s$/i'                                                            => '\1',
            '/(hive)s$/i'                                                            => '\1',
            '/([^f])ves$/i'                                                          => '\1fe',
            '/(^analy)(sis|ses)$/i'                                                  => '\1sis',
            '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)(sis|ses)$/i' => '\1sis',
            '/([ti])a$/i'                                                            => '\1um',
            '/(n)ews$/i'                                                             => '\1ews',
            '/(ss)$/i'                                                               => '\1',
            '/s$/i'                                                                  => '',
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
            'leaf'    => 'leaves',
            'loaf'    => 'loaves',
            'octopus' => 'octopuses',
            'virus'   => 'viruses',
            'person'  => 'people',
            'man'     => 'men',
            'child'   => 'children',
            'sex'     => 'sexes',
            'move'    => 'moves',
            'zombie'  => 'zombies',
            'goose'   => 'geese',
            'genus'   => 'genera',
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
            'advice',
            'aircraft',
            'art',
            'baggage',
            'butter',
            'clothing',
            'coal',
            'cotton',
            'deer',
            'equipment',
            'experience',
            'feedback',
            'fish',
            'flour',
            'food',
            'furniture',
            'gas',
            'homework',
            'impatience',
            'information',
            'jeans',
            'knowledge',
            'leather',
            'love',
            'luggage',
            'management',
            'money',
            'moose',
            'music',
            'news',
            'oil',
            'patience',
            'police',
            'polish',
            'progress',
            'research',
            'rice',
            'salmon',
            'sand',
            'series',
            'sheep',
            'silk',
            'sms',
            'soap',
            'spam',
            'species',
            'staff',
            'sugar',
            'swine',
            'talent',
            'toothpaste',
            'traffic',
            'travel',
            'vinegar',
            'weather',
            'wood',
            'wool',
            'work',
        ];
    }
}
