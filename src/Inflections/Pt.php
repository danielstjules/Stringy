<?php

namespace Stringy\Inflections;

/**
 * Portuguese inflection rules.
 */
class Pt extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/^(alem|c|p)ao$/i'                                 => '\1aes',
            '/^(irm|m)ao$/i'                                    => '\1aos',
            '/ao$/i'                                            => 'oes',
            '/^(alem|c|p)ão$/i'                                 => '\1ães',
            '/^(irm|m)ão$/i'                                    => '\1ãos',
            '/ão$/i'                                            => 'ões',
            '/^(|g)ás$/i'                                       => '\1ases',
            '/^(japon|escoc|ingl|dinamarqu|fregu|portugu)ês$/i' => '\1eses',
            '/m$/i'                                             => 'ns',
            '/([^aeou])il$/i'                                   => '\1is',
            '/ul$/i'                                            => 'uis',
            '/ol$/i'                                            => 'ois',
            '/el$/i'                                            => 'eis',
            '/al$/i'                                            => 'ais',
            '/(z|r)$/i'                                         => '\1es',
            '/(s)$/i'                                           => '\1',
            '/$/'                                               => 's',
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
            '/^(g|)ases$/i'                                      => '\1ás',
            '/(japon|escoc|ingl|dinamarqu|fregu|portugu)eses$/i' => '\1ês',
            '/(ae|ao|oe)s$/'                                     => 'ao',
            '/(ãe|ão|õe)s$/'                                     => 'ão',
            '/^(.*[^s]s)es$/i'                                   => '\1',
            '/sses$/i'                                           => 'sse',
            '/ns$/i'                                             => 'm',
            '/(r|t|f|v)is$/i'                                    => '\1il',
            '/uis$/i'                                            => 'ul',
            '/ois$/i'                                            => 'ol',
            '/eis$/i'                                            => 'ei',
            '/éis$/i'                                            => 'el',
            '/([^p])ais$/i'                                      => '\1al',
            '/(r|z)es$/i'                                        => '\1',
            '/^(á|gá)s$/i'                                       => '\1s',
            '/([^ê])s$/i'                                        => '\1',
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
            'abdomen'   => 'abdomens',
            'alemão'    => 'alemães',
            'artesã'    => 'artesãos',
            'álcool'    => 'álcoois',
            "árvore"    => "árvores",
            'bencão'    => 'bencãos',
            'cão'       => 'cães',
            'campus'    => 'campi',
            "cadáver"   => "cadáveres",
            'capelão'   => 'capelães',
            'capitão'   => 'capitães',
            'chão'      => 'chãos',
            'charlatão' => 'charlatães',
            'cidadão'   => 'cidadãos',
            'consul'    => 'consules',
            'cristão'   => 'cristãos',
            'difícil'   => 'difíceis',
            'email'     => 'emails',
            'escrivão'  => 'escrivães',
            'fóssil'    => 'fósseis',
            'gás'       => 'gases',
            'germens'   => 'germen',
            'grão'      => 'grãos',
            'hífen'     => 'hífens',
            'irmão'     => 'irmãos',
            'liquens'   => 'liquen',
            'mal'       => 'males',
            'mão'       => 'mãos',
            'orfão'     => 'orfãos',
            'país'      => 'países',
            'pai'       => 'pais',
            'pão'       => 'pães',
            'projétil'  => 'projéteis',
            'réptil'    => 'répteis',
            'sacristão' => 'sacristães',
            'sotão'     => 'sotãos',
            'tabelião'  => 'tabeliães',
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
            'tórax',
            'tênis',
            'ônibus',
            'lápis',
            'fênix',
        ];
    }
}
