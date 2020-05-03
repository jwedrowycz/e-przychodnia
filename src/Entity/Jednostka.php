<?php

namespace App\Entity;

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

}
