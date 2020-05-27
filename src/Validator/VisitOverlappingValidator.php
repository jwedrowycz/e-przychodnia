<?php

namespace App\Validator;

use App\Repository\WorkTimeRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\VisitRepository;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class VisitOverlappingValidator extends ConstraintValidator
{   

    private $visitRepo;
    private $workTimeRepo;

    public function __construct(VisitRepository $visitRepo, WorkTimeRepository $workTimeRepo)
    {
        $this->workTimeRepo = $workTimeRepo;
        $this->visitRepo = $visitRepo;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\VisitOverlapping */

        if (null === $value || '' === $value) {
            return;
        }
        $start = $value->getStart();
        $end = $value->getEnd();
        $unit = $value->getUnit();

        $existingVisit = $this->visitRepo->findOverlapping($start, $end, $unit);
        $workTimeValid = $this->workTimeRepo->checkWorkDay($start->format('H:i:s'), $end->format('H:i:s'), $unit->getId(), $start->format('w'));

        if(count($workTimeValid)==0){
            $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
        }
        if(count($existingVisit) > 0){
            $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}
