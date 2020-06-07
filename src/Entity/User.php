<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"numPhone"}, message="Taki numer telefonu jest już zarejestrowany")
 * @UniqueEntity(fields={"email"}, message="Taki adres e-mail jest już zarejestrowany")
 * @UniqueEntity(fields={"PESEL"}, message="Istnieje już pacjent z takim PESELem")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Podaj swój adres e-mail")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "Wpisz swoje imię")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Name nie może zawierać cyfr"
     * )
     * @Assert\Length(min=3,
     *                  max = 20,
     *                  minMessage = "Imię musi się składać conajmniej z {{ limit }} znaków",
     *                  maxMessage = "Limit znaków w polu imię to {{ limit }}" )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(message = "Wpisz swoje nazwisko")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Nazwisko nie może zawierać cyfr"
     * )
     *
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message = "Wpisz swój numer PESEL")
     * @Assert\Regex(
     *     pattern="/[^0-9]/",
     *     match=false,
     *     message="Numer pesel nie może zawierać liter"
     * )
     * @Assert\Length(min=11,
     *                  max=11,
     *                  minMessage = "Pesel może się składać jedynie z {{ limit }} cyfr",
     *                  maxMessage = "Pesel może się składać jedynie z {{ limit }} cyfr")
     * @ORM\Column(type="string", length=11)
     */
    private $PESEL;

    /**
    * @Assert\Regex(
     *     pattern="/[^0-9]/",
     *     match=false,
     *     message="Numer telefonu nie może zawierać liter"
     * )
     *  @Assert\Length(min=9,
     *                  max=9,
     *                  exactMessage = "Numer telefonu musi się składać dokładnie z {{ limit }} cyfr"
     *                 )
     * @Assert\NotBlank(message = "Wpisz swój numer telefonu")
     * @ORM\Column(type="string", length=9)
     */
    private $numPhone;

    /**
     * @Assert\NotBlank(message = "Wpisz swój adres zamieszkania, ulica/nr domu")
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @Assert\NotBlank(message = "Wpisz w jakim mieście bądź miejscowości mieszkasz")
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
    * @Assert\Regex(pattern = "/[0-9]/",
     *               match = true,
     *               message="Kod pocztowy nie może zawierać liter")
     * @Assert\NotBlank(message = "Wpisz kod pocztowy swojego miejsca zamieszkania")
     * @ORM\Column(type="string", length=6)
     *
     */
    private $postCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\NotBlank(message = "Wybierz swoją date urodzenia")
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @Assert\NotBlank(message = "Wybierz swoją płeć")
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $gender;

    /**
     * @Assert\NotBlank(message = "Wybierz województwo w którym mieszkasz")
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $voivodeship;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="user")
     */
    private $visit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {

        $this->name = ucfirst(mb_strtolower($name,"UTF-8"));

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {

        $this->lastName = ucfirst(mb_strtolower($lastName,"UTF-8"));

        return $this;
    }

    public function getPESEL(): ?string
    {
        return $this->PESEL;
    }

    public function setPESEL(string $PESEL): self
    {
        $this->PESEL = $PESEL;

        return $this;
    }

    public function getNumPhone(): ?string
    {
        return $this->numPhone;
    }

    public function setNumPhone(string $numPhone): self
    {
        $this->numPhone = $numPhone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getVoivodeship(): ?string
    {
        return $this->voivodeship;
    }

    public function setVoivodeship(?string $voivodeship): self
    {
        $this->voivodeship = $voivodeship;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->visit = new ArrayCollection();
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisit(): Collection
    {
        return $this->visit;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visit->contains($visit)) {
            $this->visit[] = $visit;
            $visit->setUser($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visit->contains($visit)) {
            $this->visit->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getUser() === $this) {
                $visit->setUser(null);
            }
        }

        return $this;
    }
}
