<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor", inversedBy="unit") 
     * @ORM\JoinColumn(nullable=false)
     */
    private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clinic", inversedBy="unit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clinic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WorkTime", mappedBy="unit", cascade={"persist", "remove"})
     */
    private $workTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="unit")
     */
    private $visit;

    public function __construct()
    {
        $this->workTime = new ArrayCollection();
        $this->visit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor= $doctor;

        return $this;
    }

    public function getClinic(): ?Clinic
    {
        return $this->clinic;
    }

    public function setClinic(?Clinic $clinic): self
    {
        $this->clinic = $clinic;

        return $this;
    }

    /**
     * @return Collection|WorkTime[]
     */
    public function getWorkTime(): Collection
    {
        return $this->workTime;
    }

    public function addWorkTime(WorkTime $workTime): self
    {
        if (!$this->workTime->contains($workTime)) {
            $this->workTime[] = $workTime;
            $workTime->setUnit($this);
        }

        return $this;
    }

    public function removeWorkTime(WorkTime $workTime): self
    {
        if ($this->workTime->contains($workTime)) {
            $this->workTime->removeElement($workTime);
            // set the owning side to null (unless already changed)
            if ($workTime->getUnit() === $this) {
                $workTime->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisit(): Collection
    {
        return $this->visit;
    }

    public function addVisit(Visit $visitum): self
    {
        if (!$this->visit->contains($visitum)) {
            $this->visit[] = $visitum;
            $visitum->setUnit($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visitum): self
    {
        if ($this->visit->contains($visitum)) {
            $this->visit->removeElement($visitum);
            // set the owning side to null (unless already changed)
            if ($visitum->getUnit() === $this) {
                $visitum->setUnit(null);
            }
        }

        return $this;
    }

}
