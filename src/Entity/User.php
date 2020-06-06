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
 * @UniqueEntity(fields={"email"}, message="Taki adres e-mail jest już zarejestrowany")
 * @UniqueEntity(fields={"PESEL"}, message="Istnieje już pacjent z takim PESELem")
 * @UniqueEntity(fields={"num_phone"}, message="Taki numer telefonu jest już zarejestrowany")
 */
//TODO: COŚ KURWA Z TYM TELEFONEM ZASTANYM NIE DZIAŁA
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
     *     message="LastName nie może zawierać cyfr"
     * )
     *
     *
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

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
    private $num_phone;

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
     *               message="Numer telefonu nie może zawierać liter")
     * @Assert\NotBlank(message = "Wpisz kod pocztowy swojego miejsca zamieszkania")
     * @ORM\Column(type="string", length=6)
     *
     */
    private $post_code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

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
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {

        $this->last_name = ucfirst(mb_strtolower($last_name,"UTF-8"));

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
        return $this->num_phone;
    }

    public function setNumPhone(string $num_phone): self
    {
        $this->num_phone = $num_phone;

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
        return $this->post_code;
    }

    public function setPostCode(string $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
        $this->created_at = new \DateTime();
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
