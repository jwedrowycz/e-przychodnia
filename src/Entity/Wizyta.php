<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WizytaRepository")
 */
class Wizyta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $data_wizyty;

    /**
     * @ORM\Column(type="time")
     */
    private $godzina_przyjecia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jednostka", inversedBy="wizyta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jednostka;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wizyta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pacjent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataWizyty(): ?\DateTimeInterface
    {
        return $this->data_wizyty;
    }

    public function setDataWizyty(\DateTimeInterface $data_wizyty): self
    {
        $this->data_wizyty = $data_wizyty;

        return $this;
    }

    public function getGodzinaPrzyjecia(): ?\DateTimeInterface
    {
        return $this->godzina_przyjecia;
    }

    public function setGodzinaPrzyjecia(\DateTimeInterface $godzina_przyjecia): self
    {
        $this->godzina_przyjecia = $godzina_przyjecia;

        return $this;
    }

    public function getJednostka(): ?Jednostka
    {
        return $this->jednostka;
    }

    public function setJednostka(?Jednostka $jednostka): self
    {
        $this->jednostka = $jednostka;

        return $this;
    }

    public function getPacjent(): ?User
    {
        return $this->pacjent;
    }

    public function setPacjent(?User $pacjent): self
    {
        $this->pacjent = $pacjent;

        return $this;
    }
}
