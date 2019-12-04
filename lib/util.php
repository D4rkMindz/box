<?php

use Moment\Moment;
use Moment\MomentException;
use Symfony\Component\Translation\Translator;

/**
 * Translation function (i18n).
 *
 * @param mixed $message
 *
 * @return string
 */
function __($message)
{
    static $translator = null;
    /* @var $translator Translator */
    if ($message instanceof Translator) {
        $translator = $message;

        return '';
    }
    $translated = $translator->trans($message);
    $context = array_slice(func_get_args(), 1);
    if (!empty($context)) {
        $translated = vsprintf($translated, $context);
    }

    return $translated;
}

/**
 * Get array value or null.
 *
 * @param string $key
 * @param array  $array
 *
 * @return mixed|null
 */
function array_value(string $key, ?array $array)
{
    return array_key_exists($key, $array) ? $array[$key] : null;
}

/**
 * Convert a datetime to ISO 8601
 *
 * @param DateTime $time
 *
 * @return string
 */
function from_time(DateTime $time)
{
    return $time->format('c');
}

/**
 * Convert an ISO 8601 string to datetime
 *
 * @param string $time
 *
 * @return DateTime
 */
function to_time(string $time)
{
    try {
        $parsed = Moment::createFromFormat(Moment::ISO8601, $time);
    } catch (Error $exception) {
        throw new InvalidArgumentException(
            'All date times must be in ISO 8601 format (YYYY-MM-DD[T]HH:mm:ss.SSS[Z])'
        );
    }

    return $parsed;
}

/**
 * Recursively remove directory
 *
 * @param $dir
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Get a class name without the namespace
 *
 * @param string $class
 *
 * @return string
 */
function class_name(string $class): string {
    $path = explode('\\', $class);
    return array_pop($path);
}

/**
 * Get only the namespace of a class
 *
 * @param string $class
 *
 * @return string
 */
function class_basename(string $class): string {
    return join(array_slice(explode('\\', $class), 0, -1), '\\');
}

/**
 * Convert an input to snake_case
 *
 * @param string $input
 *
 * @return string
 */
function to_snake_case(string $input) {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}
