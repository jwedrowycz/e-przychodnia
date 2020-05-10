<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JednostkaRepository")
 */
class Jednostka
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lekarz", inversedBy="id_jednostki") 
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_lekarza;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PoradniaInfo", inversedBy="id_jednostki")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_poradni;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CzasPracy", mappedBy="jednostka", cascade={"persist", "remove"})
     */
    private $czasPracy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wizyta", mappedBy="jednostka")
     */
    private $wizyta;

    public function __construct()
    {
        $this->czasPracy = new ArrayCollection();
        $this->wizyta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLekarza(): ?Lekarz
    {
        return $this->id_lekarza;
    }

    public function setIdLekarza(?Lekarz $id_lekarza): self
    {
        $this->id_lekarza = $id_lekarza;

        return $this;
    }

    public function getIdPoradni(): ?PoradniaInfo
    {
        return $this->id_poradni;
    }

    public function setIdPoradni(?PoradniaInfo $id_poradni): self
    {
        $this->id_poradni = $id_poradni;

        return $this;
    }

    /**
     * @return Collection|CzasPracy[]
     */
    public function getCzasPracy(): Collection
    {
        return $this->czasPracy;
    }

    public function addCzasPracy(CzasPracy $czasPracy): self
    {
        if (!$this->czasPracy->contains($czasPracy)) {
            $this->czasPracy[] = $czasPracy;
            $czasPracy->setJednostka($this);
        }

        return $this;
    }

    public function removeCzasPracy(CzasPracy $czasPracy): self
    {
        if ($this->czasPracy->contains($czasPracy)) {
            $this->czasPracy->removeElement($czasPracy);
            // set the owning side to null (unless already changed)
            if ($czasPracy->getJednostka() === $this) {
                $czasPracy->setJednostka(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Wizyta[]
     */
    public function getWizyta(): Collection
    {
        return $this->wizyta;
    }

    public function addWizytum(Wizyta $wizytum): self
    {
        if (!$this->wizyta->contains($wizytum)) {
            $this->wizyta[] = $wizytum;
            $wizytum->setJednostka($this);
        }

        return $this;
    }

    public function removeWizytum(Wizyta $wizytum): self
    {
        if ($this->wizyta->contains($wizytum)) {
            $this->wizyta->removeElement($wizytum);
            // set the owning side to null (unless already changed)
            if ($wizytum->getJednostka() === $this) {
                $wizytum->setJednostka(null);
            }
        }

        return $this;
    }

}
