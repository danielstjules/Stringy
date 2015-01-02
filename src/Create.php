<?php

namespace Stringy;

/**
 * Invokes Stringy::create and returns the generated Stringy object on success.
 *
 * @param  mixed   $str      Value to modify, after being cast to string
 * @param  string  $encoding The character encoding
 * @return Stringy A Stringy object
 * @throws \InvalidArgumentException if an array or object without a
 *         __toString method is passed as the first argument
 */
function create($str, $encoding = null)
{
    return new Stringy($str, $encoding);
}
