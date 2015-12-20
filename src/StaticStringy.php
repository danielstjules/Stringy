<?php

namespace Stringy;

class StaticStringy
{
    /**
     * A mapping of method names to the numbers of arguments it accepts. Each
     * should be two more than the equivalent Stringy method. Necessary as
     * static methods place the optional $encoding as the last parameter.
     *
     * @var string[]
     */
    protected static $methodArgs = null;

    /**
     * Creates an instance of Stringy and invokes the given method with the
     * rest of the passed arguments. The optional encoding is expected to be
     * the last argument. For example, the following:
     * StaticStringy::slice('fòôbàř', 0, 3, 'UTF-8'); translates to
     * Stringy::create('fòôbàř', 'UTF-8')->slice(0, 3);
     * The result is not cast, so the return value may be of type Stringy,
     * integer, boolean, etc.
     *
     * @param string  $name
     * @param mixed[] $arguments
     *
     * @return Stringy
     */
    public static function __callStatic($name, $arguments)
    {
        if (!static::$methodArgs) {
            $methods = (new \ReflectionClass('Stringy\Stringy'))->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                /** @var \ReflectionMethod $method */
                static::$methodArgs[$method->name] = $method->getNumberOfParameters() + 2;
            }
        }

        if (!isset(static::$methodArgs[$name])) {
            throw new \BadMethodCallException($name . ' is not a valid method');
        }

        $numArgs = count($arguments);
        $str = ($numArgs) ? $arguments[0] : '';

        if ($numArgs === static::$methodArgs[$name]) {
            $args = array_slice($arguments, 1, -1);
            $encoding = $arguments[$numArgs - 1];
        } else {
            $args = array_slice($arguments, 1);
            $encoding = null;
        }

        $stringy = Stringy::create($str, $encoding);

        return call_user_func_array(array($stringy, $name), $args);
    }
}
