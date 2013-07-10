<?php

namespace Stringy;

class Stringy {

    /**
     * Checks that the first argument ($ars[0]) supplied to the private method
     * is a string, and throws an exception if not. And if not provided, sets
     * the second argument ($ars[1]) to mb_internal_encoding(). It then calls
     * the static method.
     *
     * @param   string  $method  Private static method being called
     * @param   array   $args    Array of arguments supplied to the method call
     * @return  string  String returned by the private method called
     * @throws  BadMethodCallException    If $method doesn't exist
     * @throws  InvalidArgumentException  If $args[0] is not of type string
     */
    public static function __callStatic($method, $args) {
        if (!method_exists(__CLASS__, $method))
            throw new \BadMethodCallException("Method doesn't exist");

        if (!is_string($args[0])) {
            // Scalar type hinting isn't allowed, so have to throw exceptions
            $message = sprintf('Argument of type string expected, instead ' .
                'received an argument of type %s', gettype($args[0]));

            throw new \InvalidArgumentException($message, $args[0]);
        }

        // Set the character encoding ($args[1]/$encoding) if not provided
        if (sizeof($args) == 1 || !$args[1])
            $args[1] = mb_internal_encoding();

        return forward_static_call(array(__CLASS__, $method), $args[0], $args[1]);
    }

    /**
     * Converts the first character of the supplied string to upper case, with
     * support for multibyte strings.
     *
     * @param   string  $string    String to modify
     * @param   string  $encoding  The character encodng
     * @return  string  String with the first character being upper case
     */
    private static function upperCaseFirst($string, $encoding) {
        $first = mb_substr($string, 0, 1, $encoding);
        $rest = mb_substr($string, 1, mb_strlen($string, $encoding) - 1, $encoding);

        return mb_strtoupper($first, $encoding) . $rest;
    }

    /**
     * Converts the first character of the supplied string to lower case, with
     * support for multibyte strings.
     *
     * @param   string  $string    String to modify
     * @param   string  $encoding  The character encodng
     * @return  string  String with the first character being lower case
     */
    private static function lowerCaseFirst($string, $encoding) {
        $first = mb_substr($string, 0, 1, $encoding);
        $rest = mb_substr($string, 1, mb_strlen($string, $encoding) - 1, $encoding);

        return mb_strtolower($first, $encoding) . $rest;
    }

    /**
     * Returns a camelCase version of a supplied string, with multibyte support.
     * Trims surrounding spaces, capitalizes letters following digits, spaces,
     * dashes and underscores, and removes spaces, dashes, underscores.
     *
     * @param   string  $string  String to convert to camelCase
     * @return  string  String in camelCase
     */
    private static function camelize($string, $encoding) {
        $camelCase = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($matches) use (&$encoding) {
                return $matches[1] ? mb_strtoupper($matches[1], $encoding) : "";
            },
            self::lowerCaseFirst(trim($string), $encoding)
        );

        $camelCase = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($matches) use (&$encoding) {
                return mb_strtoupper($matches[0], $encoding);
            },
            $camelCase
        );

        return $camelCase;
    }

    /**
     * Returns an UpperCamelCase version of a supplied string, with multibyte
     * support. Trims surrounding spaces, capitalizes letters following digits,
     * spaces, dashes and underscores, and removes spaces, dashes, underscores.
     *
     * @param   string  $string  String to convert to UpperCamelCase
     * @return  string  String in UpperCamelCase
     */
    private static function upperCamelize($string, $encoding) {
        $camelCase = self::camelize($string, $encoding);

        return self::upperCaseFirst($camelCase, $encoding);
    }
}

?>
