<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicalHistoryRepository")
 */
class MedicalHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $testField;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestField(): ?string
    {
        return $this->testField;
    }

    public function setTestField(string $testField): self
    {
        $this->testField = $testField;

        return $this;
    }
}
