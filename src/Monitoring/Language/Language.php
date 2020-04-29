<?php

namespace Bizprofi\Monitoring\Language;

class Language
{
    protected static $locale = null;

    protected static $files = [];

    protected static $data = [];

    /**
     * setLocale.
     * 
     * @access	public static
     * @param	string	$code	
     * @return	void
     */
    public static function setLocale(string $code)
    {
        if (!is_dir(__DIR__.'/Data/'.$code)) {
            throw new \InvalidArgumentException('No such locale: '.__DIR__.'/Data/'.$code);
        }

        static::$locale = $code;
    }

    /**
     * getLocale.
     *
     * @access	public static
     * @return	mixed
     */
    public static function getLocale(): string
    {
        return static::$locale;
    }

    /**
     * get.
     *
     * @access	public static
     * @param	string	$code
     * @param	array 	$params	Default: []
     * @return	string
     */
    public static function get(string $code, array $params = []): string
    {
        if (empty($params)) {
            return static::$data[$code];
        }

        return strtr(static::$data[$code], $params);
    }

    /**
     * loadFile.
     *
     * @access	public static
     * @param	string	$filename
     * @return	void
     */
    public static function loadFile(string $filename)
    {
        if (array_key_exists($filename, static::$files)) {
            return; // Already loaded
        }

        $path = __DIR__.'/Data/'.static::getLocale().'/'.$filename.'.php';
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('No such locale file');
        }

        $data = include($path);
        if (!is_array($data)) {
            throw new \OutOfBoundsException('File "'.$path.'" does not contain a valid language data');
        }

        foreach ($data as $code => $item) {
            if (!is_string($code) || !is_string($item)) {
                throw new \InvalidArgumentException('Invalid language data format');
            }

            static::$data[$code] = $item;
        }

        static::$files[] = $filename;
    }
}
