<?php

namespace Stringy\Inflections;

/**
 * Spanish inflection rules.
 */
class Es extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/ú([sn])$/i'     => 'u\1es',
            '/ó([sn])$/i'     => 'o\1es',
            '/í([sn])$/i'     => 'i\1es',
            '/é([sn])$/i'     => 'e\1es',
            '/á([sn])$/i'     => 'a\1es',
            '/z$/i'           => 'ces',
            '/([aeiou]s)$/i'  => '\1',
            '/([^aeéiou])$/i' => '\1es',
            '/$/'             => 's',
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
            '/ereses$/' => 'erés',
            '/iones$/'  => 'ión',
            '/ces$/'    => 'z',
            '/es$/'     => '',
            '/s$/'      => '',
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
            'el'           => 'los',
            'lunes'        => 'lunes',
            'rompecabezas' => 'rompecabezas',
            'crisis'       => 'crisis',
            'papá'         => 'papás',
            'mamá'         => 'mamás',
            'sofá'         => 'sofás',
            // because 'mes' is considered already a plural
            'mes'          => 'meses',
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
