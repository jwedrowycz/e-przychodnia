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
        if (null === $value || '' === $value) {
            return;
        }
        $start = $value->getStart();
        $end = $value->getEnd();
        $unit = $value->getUnit();

        $existingVisit = $this->visitRepo->findOverlapping($start, $end, $unit);
        $workTimeValid = $this->workTimeRepo->checkWorkDay($unit->getId(), $start->format('w'));

        if(count($workTimeValid) == 0 or count($existingVisit) > 0){
            $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}
