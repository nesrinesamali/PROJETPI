<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "veuillez saisir le Nom")]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "veuillez saisir le Prenom ")]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typemaladie = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $specialite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $groupesanguin = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $statuteligibilite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(length: 150)]
    private ?string $brochure = null;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTypemaladie(): ?string
    {
        return $this->typemaladie;
    }

    public function setTypemaladie(?string $typemaladie): self
    {
        $this->typemaladie = $typemaladie;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getGroupesanguin(): ?string
    {
        return $this->groupesanguin;
    }

    public function setGroupesanguin(?string $groupesanguin): self
    {
        $this->groupesanguin = $groupesanguin;

        return $this;
    }

    public function getStatuteligibilite(): ?string
    {
        return $this->statuteligibilite;
    }

    public function setStatuteligibilite(?string $statuteligibilite): self
    {
        $this->statuteligibilite = $statuteligibilite;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getBrochure(): ?string
    {
        return $this->brochure;
    }

    public function setBrochure(string $brochure): static
    {
        $this->brochure = $brochure;

        return $this;
    }
}
