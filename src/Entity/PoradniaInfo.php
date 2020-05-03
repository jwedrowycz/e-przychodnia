<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Poradnia
 *
 * @ORM\Table(name="poradnia")
 * @ORM\Entity(repositoryClass="App\Repository\PoradniaInfoRepository")
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
     * @var string|null
     *
     * @ORM\Column(name="nazwa", type="string", length=255, nullable=true)
     */
    private $nazwa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Jednostka", mappedBy="id_poradni")
     */
    private $id_jednostki;

    public function __construct()
    {
        $this->id_jednostki = new ArrayCollection();
    }

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

    /**
     * @return Collection|Jednostka[]
     */
    public function getIdJednostki(): Collection
    {
        return $this->id_jednostki;
    }

    public function addIdJednostki(Jednostka $idJednostki): self
    {
        if (!$this->id_jednostki->contains($idJednostki)) {
            $this->id_jednostki[] = $idJednostki;
            $idJednostki->setIdPoradni($this);
        }

        return $this;
    }

    public function removeIdJednostki(Jednostka $idJednostki): self
    {
        if ($this->id_jednostki->contains($idJednostki)) {
            $this->id_jednostki->removeElement($idJednostki);
            // set the owning side to null (unless already changed)
            if ($idJednostki->getIdPoradni() === $this) {
                $idJednostki->setIdPoradni(null);
            }
        }

        return $this;
    }


}
