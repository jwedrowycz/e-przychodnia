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
            // new TwigFilter('nameOfDay', [$this, 'nameOfDay']),

        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nameOfDay', [$this, 'nameOfDay']),
            new TwigFunction('roleFormat', [$this, 'roleFormat']),
            new TwigFunction('checkDuplicates', [$this, 'checkDuplicates']),
        ];
    }

    //TODO: ZROBIĆ FILTR FORMATU TELEFONU

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
        return False;
    }

    public function roleFormat($role)
    {
        if($role=='ROLE_USER'){
            return 'Użytkownik';
        }
        elseif($role=='ROLE_ADMIN'){
            return 'Administrator';
        }
        elseif($role=='ROLE_OPERATOR'){
            return 'Operator';
        }
        return False;
    }

    public function checkDuplicates($array)
    {   
        foreach($array as $val)
        {
            return $val['day'];
        }    
    }
}
