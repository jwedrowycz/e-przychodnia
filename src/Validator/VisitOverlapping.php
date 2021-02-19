<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VisitOverlapping extends Constraint
{   
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
    public $message = 'Wprowadź poprawny termin wizyty.';
}
