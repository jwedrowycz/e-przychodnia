<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoradniaInfo
 *
 * @ORM\Table(name="poradnia_info", indexes={@ORM\Index(name="FK_poradnia_info_poradnia_id", columns={"id_poradni"}), @ORM\Index(name="FK_poradnia_info_lekarz_id_lekarza", columns={"id_lekarza"})})
 * @ORM\Entity
 */
class PoradniaInfo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Lekarz
     *
     * @ORM\ManyToOne(targetEntity="Lekarz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_lekarza", referencedColumnName="id_lekarza")
     * })
     */
    private $idLekarza;

    /**
     * @var \Poradnia
     *
     * @ORM\ManyToOne(targetEntity="Poradnia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_poradni", referencedColumnName="id")
     * })
     */
    private $idPoradni;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLekarza(): ?Lekarz
    {
        return $this->idLekarza;
    }

    public function setIdLekarza(?Lekarz $idLekarza): self
    {
        $this->idLekarza = $idLekarza;

        return $this;
    }

    public function getIdPoradni(): ?Poradnia
    {
        return $this->idPoradni;
    }

    public function setIdPoradni(?Poradnia $idPoradni): self
    {
        $this->idPoradni = $idPoradni;

        return $this;
    }


}
