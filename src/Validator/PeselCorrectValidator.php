<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Symfony\Component\Validator\Exception\UnexpectedValueException;


class PeselCorrectValidator extends ConstraintValidator
{   

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\VisitOverlapping */

        if (null === $value || '' === $value) {
            return;
        }
        $month = substr($value, 2,2);
        $day = substr($value, 4,2);
        $century = 0;
        if (substr($month,0,1)=='2' || substr($month,0,1)=='3') { 
            $century = 2000; 
            $month = intval($month) - 20;
        }
        $year = $century + substr($value, 0, 2);
        $days = date('t', mktime(0, 0, 0, $month, 1, $year)); 
        if ($day > $days)
        {
            $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
        }
    }

  
}
