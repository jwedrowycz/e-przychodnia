<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Taki adres e-mail jest już zarejestrowany")
 * @UniqueEntity(fields={"PESEL"}, message="Istnieje już pacjent z takim PESELem")
 * @UniqueEntity(fields={"telefon"}, message="Taki numer telefonu jest już zarejestrowany")
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
     *     message="Imie nie może zawierać cyfr"
     * )
     * @Assert\Length(min=3,
     *                  max = 20,
     *                  minMessage = "Imię musi się składać conajmniej z {{ limit }} znaków",
     *                  maxMessage = "Limit znaków w polu imię to {{ limit }}" )
     * @ORM\Column(type="string", length=255)
     */
    private $imie;

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
    private $nazwisko;

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
     *                  exactMessage = "Numer telefonu może się składać dokładnie z {{ limit }} cyfr"
     *                 )
     * @Assert\NotBlank(message = "Wpisz swój numer telefonu")
     * @ORM\Column(type="string", length=9)
     */
    private $telefon;

    /**
     * @Assert\NotBlank(message = "Wpisz swój adres zamieszkania, ulica/nr domu")
     * @ORM\Column(type="string", length=255)
     */
    private $adres_zamieszkania;

    /**
     * @Assert\NotBlank(message = "Wpisz w jakim mieście bądź miejscowości mieszkasz")
     * @ORM\Column(type="string", length=255)
     */
    private $miasto;

    /**
    * @Assert\Regex(pattern = "/[0-9]/",
     *               match = true,
     *               message="Numer telefonu nie może zawierać liter")
     * @Assert\NotBlank(message = "Wpisz kod pocztowy swojego miejsca zamieszkania")
     * @ORM\Column(type="string", length=6)
     * 
     */
    private $kod_pocztowy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_dolaczenia;

    /**
     * @Assert\NotBlank(message = "Wybierz swoją date urodzenia")
     * @ORM\Column(type="date", nullable=true)
     */
    private $data_urodzenia;

    /**
     * @Assert\NotBlank(message = "Wybierz swoją płeć")
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $plec;

    /**
     * @Assert\NotBlank(message = "Wybierz województwo w którym mieszkasz")
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $wojewodztwo;

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

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(string $imie): self
    {   
   
        $this->imie = ucfirst(mb_strtolower($imie,"UTF-8"));

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(string $nazwisko): self
    {
       
        $this->nazwisko = ucfirst(mb_strtolower($nazwisko,"UTF-8"));

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

    public function getTelefon(): ?string
    {
        return $this->telefon;
    }

    public function setTelefon(string $telefon): self
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function getAdresZamieszkania(): ?string
    {
        return $this->adres_zamieszkania;
    }

    public function setAdresZamieszkania(string $adres_zamieszkania): self
    {
        $this->adres_zamieszkania = $adres_zamieszkania;

        return $this;
    }

    public function getMiasto(): ?string
    {
        return $this->miasto;
    }

    public function setMiasto(string $miasto): self
    {
        $this->miasto = $miasto;

        return $this;
    }

    public function getKodPocztowy(): ?string
    {
        return $this->kod_pocztowy;
    }

    public function setKodPocztowy(string $kod_pocztowy): self
    {
        $this->kod_pocztowy = $kod_pocztowy;

        return $this;
    }

    public function getDataDolaczenia(): ?\DateTimeInterface
    {
        return $this->data_dolaczenia;
    }

    public function setDataDolaczenia(\DateTimeInterface $data_dolaczenia): self
    {
        $this->data_dolaczenia = $data_dolaczenia;

        return $this;
    }

    public function getDataUrodzenia(): ?\DateTimeInterface
    {
        return $this->data_urodzenia;
    }

    public function setDataUrodzenia(?\DateTimeInterface $data_urodzenia): self
    {
        $this->data_urodzenia = $data_urodzenia;

        return $this;
    }

    public function getPlec(): ?string
    {
        return $this->plec;
    }

    public function setPlec(?string $plec): self
    {
        $this->plec = $plec;

        return $this;
    }

    public function getWojewodztwo(): ?string
    {
        return $this->wojewodztwo;
    }

    public function setWojewodztwo(?string $wojewodztwo): self
    {
        $this->wojewodztwo = $wojewodztwo;

        return $this;
    }

    public function __construct()
    {
        $this->data_dolaczenia = new \DateTime(); 
    }
}