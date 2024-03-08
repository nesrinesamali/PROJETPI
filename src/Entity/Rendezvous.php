<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
#[ORM\Table(name: "rendezvous")]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "vous devez remplir ce champ")]
    #[Assert\Length(
        min: 4,
        minMessage: "Le champ doit contenir au moins {{ limit }} caractères.",
        
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z\s]+$/",
        message: "Seules les lettres et les espaces sont autorisés dans ce champ."
    )]
    
    private ?string $nompatient;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 4,
        minMessage: "Le champ doit contenir au moins {{ limit }} caractères.",
        
    )]
    #[Assert\NotBlank(message: "vous devez remplir ce champ")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z\s]+$/",
        message: "Seules les lettres et les espaces sont autorisés dans ce champ."
    )]
    
    private ?string $nommedecin;

    #[ORM\Column(type: "date")]
    #[Assert\NotBlank(message: "vous devez remplir ce champ")]
    private ?\DateTimeInterface $date;

    #[ORM\Column(type: "time")]
    #[Assert\NotBlank(message: "vous devez remplir ce champ")]
    private ?\DateTimeInterface $heure;

 

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reponse $reponse = null;

    #[ORM\Column]
    private ?bool $etat = false;

    #[ORM\ManyToOne(inversedBy: 'rendezvouses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->heure = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNompatient(): ?string
    {
        return $this->nompatient;
    }

    public function setNompatient(string $nompatient): static
    {
        $this->nompatient = $nompatient;
        return $this;
    }

    public function getNommedecin(): ?string
    {
        return $this->nommedecin;
    }

    public function setNommedecin(string $nommedecin): static
    {
        $this->nommedecin = $nommedecin;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
{
    if ($date !== null) {
        $this->date = $date;
    }
    return $this;
}


    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;
        return $this;
    }

   

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function __toString(): string
    {
        // Customize the string representation of your entity
        return $this->nompatient; // or any other property you want to display
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
    public function toString(): string
{
    // Customize the string representation of your entity
    return $this->nompatient . ' ' . $this->nommedecin . ' ' . $this->date->format('m/d/Y') . ' ' . $this->heure->format('H:i:s');
}

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

