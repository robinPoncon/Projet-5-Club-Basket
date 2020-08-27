<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Preg_match extends AbstractExtension
{

    public function getFunctions()
    {
        return [new TwigFunction('preg_match', [$this, 'pregMatch']),];
    }

    public function pregMatch($pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);

        return $matches;
    }

}