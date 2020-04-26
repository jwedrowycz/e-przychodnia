<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wizyta
 *
 * @ORM\Table(name="wizyta")
 * @ORM\Entity
 */
class Wizyta
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
     * @var \DateTime
     *
     * @ORM\Column(name="data_wizyty", type="date", nullable=false)
     */
    private $dataWizyty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="godzina_wizyty", type="time", nullable=false)
     */
    private $godzinaWizyty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataWizyty(): ?\DateTimeInterface
    {
        return $this->dataWizyty;
    }

    public function setDataWizyty(\DateTimeInterface $dataWizyty): self
    {
        $this->dataWizyty = $dataWizyty;

        return $this;
    }

    public function getGodzinaWizyty(): ?\DateTimeInterface
    {
        return $this->godzinaWizyty;
    }

    public function setGodzinaWizyty(\DateTimeInterface $godzinaWizyty): self
    {
        $this->godzinaWizyty = $godzinaWizyty;

        return $this;
    }


}
