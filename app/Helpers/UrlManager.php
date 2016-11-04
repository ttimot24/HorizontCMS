<?php


class UrlManager
{
    public static function get_slugs()
    {
        if (isset($_GET['r'])) {
            $url = rtrim($_GET['r'], '/');
            $url = explode('/', $url);

            return $url;
        } elseif (isset($_GET['route'])) {
            $url = rtrim($_GET['route'], '/');
            $url = explode('/', $url);

            return $url;
        } else {
            return;
        }
    }

    public static function seo_url($string)
    {

     /*   $string = strtolower($string);

     //   $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);

        $string = preg_replace("/[\s_]/", "-", $string);

        $string = str_replace(str_split(",'?!"), "-", $string);

        return $string;*/

        return str_slug($string, '-');
    }

    public static function prepare_slug($string)
    {
        return str_replace('-', '%', $string);
    }

    public static function http_protocol($string)
    {
        if (strpos($string, 'http') === false) {
            $string = 'http://'.$string;
        }

        return $string;
    }
}
