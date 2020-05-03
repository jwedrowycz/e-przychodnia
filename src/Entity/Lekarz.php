<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LekarzRepository")
 */
class Lekarz
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
    private $imie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $numerPWZ;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Jednostka", mappedBy="id_lekarza")
     */
    private $id_jednostki;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specjalizacja;

    public function __construct()
    {
        $this->id_jednostki = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    public function getNumerPWZ(): ?string
    {
        return $this->numerPWZ;
    }

    public function setNumerPWZ(string $numerPWZ): self
    {
        $this->numerPWZ = $numerPWZ;

        return $this;
    }

    /**
     * @return Collection|Jednostka[]
     */
    public function getIdJednostki(): Collection
    {
        return $this->id_jednostki;
    }

    public function addIdJednostki(Jednostka $idJednostki): self
    {
        if (!$this->id_jednostki->contains($idJednostki)) {
            $this->id_jednostki[] = $idJednostki;
            $idJednostki->setIdLekarza($this);
        }

        return $this;
    }

    public function removeIdJednostki(Jednostka $idJednostki): self
    {
        if ($this->id_jednostki->contains($idJednostki)) {
            $this->id_jednostki->removeElement($idJednostki);
            // set the owning side to null (unless already changed)
            if ($idJednostki->getIdLekarza() === $this) {
                $idJednostki->setIdLekarza(null);
            }
        }

        return $this;
    }

    public function getSpecjalizacja(): ?string
    {
        return $this->specjalizacja;
    }

    public function setSpecjalizacja(string $specjalizacja): self
    {
        $this->specjalizacja = $specjalizacja;

        return $this;
    }
}
