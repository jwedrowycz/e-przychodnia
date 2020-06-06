<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 * @UniqueEntity(fields={"numPwz"}, message="Lekarz o tym numerze PWZ już istnieje")
 */
class Doctor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Wpisz imię lekarza")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(message = "Wpisz nazwisko lekarza")
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message = "Wpisz numer PWZ")
     * @Assert\Regex(
     *     pattern="/[^0-9]/",
     *     match=false,
     *     message="Numer PWZ nie może zawierać liter"
     * )
     * @Assert\Length(min=7,
     *                  max=7,
     *                  minMessage = "Numer PWZ może się składać jedynie z {{ limit }} cyfr",
     *                  maxMessage = "Numer PWZ może się składać jedynie z {{ limit }} cyfr")
     * @ORM\Column(type="string", length=7)
     */
    private $numPwz;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Unit", mappedBy="doctor")
     */
    private $unit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $spec;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function __construct()
    {
        $this->unit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNumPwz(): ?string
    {
        return $this->numPwz;
    }

    public function setNumPwz(string $numPwz): self
    {
        $this->numPwz = $numPwz;

        return $this;
    }

    /**
     * @return Collection|Unit[]
     */
    public function getUnit(): Collection
    {
        return $this->unit;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->unit->contains($unit)) {
            $this->unit[] = $unit;
            $unit->setDoctor($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->unit->contains($unit)) {
            $this->unit->removeElement($unit);
            // set the owning side to null (unless already changed)
            if ($unit->getDoctor() === $this) {
                $unit->setDoctor(null);
            }
        }

        return $this;
    }

    public function getSpec(): ?string
    {
        return $this->spec;
    }

    public function setSpec(string $spec): self
    {
        $this->spec = $spec;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
