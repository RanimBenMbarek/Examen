<?php

namespace App\TwigFiltres;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwigExtensions extends AbstractExtension
{
    public function getFilters()
    {
        return  [
            new TwigFilter('defaultImage',[$this,'defaultImage'])
        ];
    }
    public function defaultImage(String $path) : String
    {
        if (strlen(trim($path)) == 0) {
            return 'chicken.png';
        } else {
            return $path;
        }
    }
}