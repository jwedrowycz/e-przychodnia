<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LekarzSpec
 *
 * @ORM\Table(name="lekarz_spec", indexes={@ORM\Index(name="FK_lekarz_spec_lekarz_id_lekarza", columns={"id_lekarza"}), @ORM\Index(name="FK_lekarz_spec_specjalizacja_id", columns={"id_spec"})})
 * @ORM\Entity
 */
class LekarzSpec
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
     * @var \Specjalizacja
     *
     * @ORM\ManyToOne(targetEntity="Specjalizacja")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_spec", referencedColumnName="id")
     * })
     */
    private $idSpec;

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

    public function getIdSpec(): ?Specjalizacja
    {
        return $this->idSpec;
    }

    public function setIdSpec(?Specjalizacja $idSpec): self
    {
        $this->idSpec = $idSpec;

        return $this;
    }


}
