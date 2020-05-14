<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nameOfDay', [$this, 'nameOfDay']),
        ];
    }

    public function nameOfDay($num)
    {        
        if($num===1){
            return 'Poniedziałek';
        }
        elseif($num===2){
            return 'Wtorek'; 
        }
        elseif($num===3){
            return 'Środa';
        }
        elseif($num===4){
            return 'Czwartek';
        }
        elseif($num===5){
            return 'Piątek';
        }

    }
}