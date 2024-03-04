<?php

namespace App\Entity;

use App\Repository\DonsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: DonsRepository::class)]
class Dons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message:"vous devez remplir ce champ!!!")]
    private ?\DateTimeInterface $DateDon = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message:"vous devez remplir ce champ!!!")]
    private ?\DateTimeInterface $datedernierdon = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
    private ?string $GroupeSanguin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
    private ?string $Etatmarital = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
    private ?string $typededon = null;

    #[ORM\Column]
#[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
#[Assert\Regex(pattern: '/^\d{8}$/', message: 'le numéro NIN doit être composé de 8 chiffres')]
private ?int $Cin = null;
    #[ORM\ManyToOne(inversedBy: 'don')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:"vous devez remplir ce champ!!!")]
    private ?CentreDon $centreDon = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateDon(): ?\DateTimeInterface
    {
        return $this->DateDon;
    }

    public function setDateDon(?\DateTimeInterface $DateDon): self
    {
        $this->DateDon = $DateDon;

        return $this;
    }


    

    // Autres méthodes et propriétés...

    public function getDatedernierdon(): ?\DateTimeInterface
    {
        return $this->datedernierdon;
    }

    public function setDatedernierdon(?\DateTimeInterface $datedernierdon): self
    {
        $this->datedernierdon = $datedernierdon;

        return $this;
    }
    

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getGroupeSanguin(): ?string
    {
        return $this->GroupeSanguin;
    }

    public function setGroupeSanguin(string $GroupeSanguin): static
    {
        $this->GroupeSanguin = $GroupeSanguin;

        return $this;
    }

    public function getEtatmarital(): ?string
    {
        return $this->Etatmarital;
    }

    public function setEtatmarital(string $Etatmarital): static
    {
        $this->Etatmarital = $Etatmarital;

        return $this;
    }

    public function getTypededon(): ?string
    {
        return $this->typededon;
    }

    public function setTypededon(string $typededon): static
    {
        $this->typededon = $typededon;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->Cin;
    }

    public function setCin(int $Cin): static
    {
        $this->Cin = $Cin;

        return $this;
    }

    public function getCentreDon(): ?CentreDon
    {
        return $this->centreDon;
    }

    public function setCentreDon(?CentreDon $centreDon): static
    {
        $this->centreDon = $centreDon;

        return $this;
    }
}
