<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Badanie
 *
 * @ORM\Table(name="badanie", indexes={@ORM\Index(name="FK_badanie_wizyta_id_wizyty", columns={"wizyta"})})
 * @ORM\Entity
 */
class Badanie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_badania", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBadania;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nazwa", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nazwa = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="wywiad", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $wywiad = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="czas_zatwierdzenia", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $czasZatwierdzenia = 'current_timestamp()';

    /**
     * @var string|null
     *
     * @ORM\Column(name="zalecenia", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $zalecenia = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="skierowanie", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $skierowanie = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="recepta", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $recepta = 'NULL';

    /**
     * @var \Wizyta
     *
     * @ORM\ManyToOne(targetEntity="Wizyta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wizyta", referencedColumnName="id_wizyty")
     * })
     */
    private $wizyta;

    public function getIdBadania(): ?int
    {
        return $this->idBadania;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(?string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getWywiad(): ?string
    {
        return $this->wywiad;
    }

    public function setWywiad(?string $wywiad): self
    {
        $this->wywiad = $wywiad;

        return $this;
    }

    public function getCzasZatwierdzenia(): ?\DateTimeInterface
    {
        return $this->czasZatwierdzenia;
    }

    public function setCzasZatwierdzenia(\DateTimeInterface $czasZatwierdzenia): self
    {
        $this->czasZatwierdzenia = $czasZatwierdzenia;

        return $this;
    }

    public function getZalecenia(): ?string
    {
        return $this->zalecenia;
    }

    public function setZalecenia(?string $zalecenia): self
    {
        $this->zalecenia = $zalecenia;

        return $this;
    }

    public function getSkierowanie(): ?string
    {
        return $this->skierowanie;
    }

    public function setSkierowanie(?string $skierowanie): self
    {
        $this->skierowanie = $skierowanie;

        return $this;
    }

    public function getRecepta(): ?string
    {
        return $this->recepta;
    }

    public function setRecepta(?string $recepta): self
    {
        $this->recepta = $recepta;

        return $this;
    }

    public function getWizyta(): ?Wizyta
    {
        return $this->wizyta;
    }

    public function setWizyta(?Wizyta $wizyta): self
    {
        $this->wizyta = $wizyta;

        return $this;
    }


}
