<?php

namespace Stringy\Inflections;

/**
 * French inflection rules.
 */
class Fr extends Inflector
{
    /**
     * Return an array of pluralization rules, from most to least specific, in the form $rule => $replacement
     *
     * @return array
     */
    public function pluralRules()
    {
        return [
            '/(s|x|z)$/'                                               => '\1',
            '/(b|cor|ém|gemm|soupir|trav|vant|vitr)ail$/'              => '\1aux',
            '/ail$/'                                                   => 'ails',
            '/al$/'                                                    => 'aux',
            '/(bleu|émeu|landau|lieu|pneu|sarrau)$/'                   => '\1s',
            '/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)$/' => '\1x',
            '/$/'                                                      => 's',
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
            '/(b|cor|ém|gemm|soupir|trav|vant|vitr)aux$/'               => '\1ail',
            '/ails$/'                                                   => 'ail',
            '/(journ|chev)aux$/'                                        => '\1al',
            '/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)x$/' => '\1',
            '/s$/'                                                      => '',
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
            'monsieur'     => 'messieurs',
            'madame'       => 'mesdames',
            'mademoiselle' => 'mesdemoiselles',
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
