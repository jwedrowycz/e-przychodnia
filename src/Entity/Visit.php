<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WizytaRepository")
 */
class Visit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Unit.php", inversedBy="wizyta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jednostka;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wizyta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pacjent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $rozpoczecie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $zakonczenie;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJednostka(): ?Unit
    {
        return $this->jednostka;
    }

    public function setJednostka(?Unit $jednostka): self
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


    public function getRozpoczecie(): ?\DateTimeInterface
    {
        return $this->rozpoczecie;
    }

    public function setRozpoczecie(\DateTimeInterface $rozpoczecie): self
    {
        $this->rozpoczecie = $rozpoczecie;

        return $this;
    }

    public function getZakonczenie(): ?\DateTimeInterface
    {
        return $this->zakonczenie;
    }

    public function setZakonczenie(\DateTimeInterface $zakonczenie): self
    {
        $this->zakonczenie = $zakonczenie;

        return $this;
    }

}
