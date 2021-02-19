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
            new TwigFilter('statusFormat', [$this, 'statusFormat']),
            new TwigFilter('roleFormat', [$this, 'roleFormat']),
            new TwigFilter('phoneFormat', [$this, 'phoneFormat']),


        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nameOfDay', [$this, 'nameOfDay']),
            // new TwigFunction('roleFormat', [$this, 'roleFormat']),
            new TwigFunction('checkDuplicates', [$this, 'checkDuplicates']),
            new TwigFunction('phoneFormat', [$this, 'phoneFormat']),
        ];
    }

    public function phoneFormat($number)
    {
        $firstChain = substr($number, 0, 3);
        $secondChain = substr($number, 3, 3);
        $thirdChain = substr($number, 6, 3);
        $formatedNumberPhone = $firstChain . ' ' . $secondChain . ' ' . $thirdChain;

        return $formatedNumberPhone;
    }

    public function nameOfDay($num)
    {        
        if($num===1) return 'Poniedziałek';
        elseif($num===2) return 'Wtorek'; 
        elseif($num===3) return 'Środa';
        elseif($num===4) return 'Czwartek';
        elseif($num===5) return 'Piątek';
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

    public function statusFormat($status)
    {
        if($status == 1)
        {
            return 'Aktywny';
        }
        else {
            return 'Nieaktywny';
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
