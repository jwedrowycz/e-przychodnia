<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CzasPracyRepository")
 */
class CzasPracy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="time")
     */
    private $start;

    /**
     * @ORM\Column(type="time")
     */
    private $koniec;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jednostka", inversedBy="czasPracy")
     */
    private $jednostka;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dzien;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getKoniec(): ?\DateTimeInterface
    {
        return $this->koniec;
    }

    public function setKoniec(\DateTimeInterface $koniec): self
    {
        $this->koniec = $koniec;

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

    public function getDzien(): ?int
    {
        return $this->dzien;
    }

    public function setDzien(int $dzien): self
    {
        $this->dzien = $dzien;

        return $this;
    }
}
