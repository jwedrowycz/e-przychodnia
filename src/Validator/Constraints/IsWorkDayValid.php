<?php


namespace App\Validator\Constraints;

use App\Repository\VisitRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


/**
 * @Annotation
 */
class IsWorkDayValid extends ConstraintValidator
{

    private $visitRepo;


    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof IsWorkDayValid) {
            throw new UnexpectedTypeException($constraint, IsWorkDayValid::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $object || '' === $object) {
            return;
        }

        $conflicts = $this->visitRepo->findOverlapping($object->getStart(), $object->getEnd());

        if (count($conflicts) > 0) {
            $this->context->addViolation('Ten termin już jest zajęty');
        }
    }

}