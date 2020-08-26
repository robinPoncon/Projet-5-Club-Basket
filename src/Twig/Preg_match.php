<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Preg_match extends AbstractExtension
{

    public function getFilters()
    {
        return [new TwigFilter('preg_match', [$this, 'pregMatch']),];
    }

    public function pregMatch($pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);

        return $matches;
    }

}