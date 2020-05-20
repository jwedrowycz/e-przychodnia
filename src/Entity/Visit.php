<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\VisitOverlapping;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 * @VisitOverlapping()
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="visit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="visit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="datetime")
     */
    private $submit_date;

    public function __construct()
    {
        $this->submit_date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeInterface
    {
        return $this->submit_date;
    }

    public function setSubmitDate(\DateTimeInterface $submit_date): self
    {
        $this->submit_date = $submit_date;

        return $this;
    }

    public function __toString() {
        return $this->unit;
    }

    /**
     * @Assert\IsTrue(message="Zła data - data rozpoczęcia i zakończenia wizyty musi być tego samego dnia.")
     */
    public function isStartAndEndEqual()
    {

        return date_format($this->start,'Y-m-d') === date_format($this->end, 'Y-m-d');
    }

    /**
     * @Assert\IsTrue(message="Zły czas - godzina zakończenia nie może być wcześniejsza niż godzina rozpoczęcia ")
     */
    public function isTimeValid()
    {
        return date_format($this->start,'H:i:s') < date_format($this->end, 'H:i:s');
    }

    /**
     * @Assert\IsTrue(message="Zła data - nie możesz zarezerwować wizyty w przeszłości")
     */
    public function isDatePast()
    {
        $tomorrowDate = new \DateTime('tomorrow');
        if($this->start >= $tomorrowDate) {
            return True;
        }
        else if($this->end >= $tomorrowDate){
            return True;
        }
        else {
            return False;
        }
    }

    /**
     * @Assert\IsTrue(message="Zła data - zły czas wizyty")
     */
    public function isVisitRightTimeEnd()
    {
        $tw = new \DateTime('00:20:00');
        $tw = $tw->format('i:s');

        $ft = new \DateTime('00:40:00');
        $ft =$ft->format('i:s');

        $zero = new \DateTime('00:00:00');
        $zero = $zero->format('i:s');
        $times = [$tw, $ft, $zero];
        if(in_array($this->start->format('i:s'), $times) and in_array($this->end->format('i:s'), $times))
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    /**
     * @Assert\IsTrue(message="Zła data - czas wizyt nie może być dłuższy niż 20 minut")
     */
    public function isVisitRightTime()
    {
        $diff = $this->start->diff($this->end);
        if( $diff->format('%i') == 20 )
        {
            return True;
        }
        else {
            return False;
        }
    }

}
