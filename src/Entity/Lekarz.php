<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lekarz
 *
 * @ORM\Table(name="lekarz")
 * @ORM\Entity
 */
class Lekarz
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lekarza", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLekarza;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imie", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $imie = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="nazwisko", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nazwisko = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="numer_PWZ", type="string", length=7, nullable=true, options={"default"="NULL"})
     */
    private $numerPwz = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="PESEL", type="string", length=11, nullable=true, options={"default"="NULL"})
     */
    private $pesel = 'NULL';

    public function getIdLekarza(): ?int
    {
        return $this->idLekarza;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(?string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(?string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    public function getNumerPwz(): ?string
    {
        return $this->numerPwz;
    }

    public function setNumerPwz(?string $numerPwz): self
    {
        $this->numerPwz = $numerPwz;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }


}
