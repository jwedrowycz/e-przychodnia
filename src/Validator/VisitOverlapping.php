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
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Wprowadź poprawną datę wizyty.';
}
