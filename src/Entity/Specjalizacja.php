<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specjalizacja
 *
 * @ORM\Table(name="specjalizacja")
 * @ORM\Entity
 */
class Specjalizacja
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
     * @var string|null
     *
     * @ORM\Column(name="nazwa", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nazwa = 'NULL';

    public function getId(): ?int
    {
        return $this->id;
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


}
