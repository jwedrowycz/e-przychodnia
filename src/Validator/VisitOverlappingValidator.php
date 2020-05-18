<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\VisitRepository;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class VisitOverlappingValidator extends ConstraintValidator
{   

    private $visitRepo;

    public function __construct(VisitRepository $visitRepo)
    {
        $this->visitRepo = $visitRepo;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\VisitOverlapping */

        if (null === $value || '' === $value) {
            return;
        }
        $start = $value->getStart()->format('Y-m-d H:i:s');
        $end = $value->getEnd()->format('Y-m-d H:i:s');
        $unit = $value->getUnit();
        
      
        // $u = $unit->getId();
        // if (!is_string($value)) {
        //     // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
        //     throw new UnexpectedValueException($value->getStart(), $s . ' ' . $e . ' ' . $u);

        //     // separate multiple types using pipes
        //     // throw new UnexpectedValueException($value, 'string|int');
        // }

      
        // TODO: implement the validation here
        // $existingVisit = $this->visitRepo->findOverlapping($value->getStart(), $value->getEnd(), $value->getUnit()->getId());
        $existingVisit = $this->visitRepo->findOverlapping($start, $end, $unit->getId());
        if (count($existingVisit) > 0){
            $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}
