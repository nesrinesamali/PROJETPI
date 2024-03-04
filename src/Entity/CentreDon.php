<?php

namespace App\Entity;

use App\Repository\CentreDonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CentreDonRepository::class)]
class CentreDon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez mettre le type!!!")]
    private ?string $NomCentre = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message:"vous devez mettre le type!!!")]
    private ?\DateTimeInterface $DateOuverture = null;


    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message:"vous devez mettre le type!!!")]
    private ?\DateTimeInterface $datefermeture = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez mettre le type!!!")]
    private ?string $gouvernorat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"vous devez mettre le type!!!")]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "vous devez mettre le type!!!")]
    #[Assert\Email(message: "L'adresse email {{ value }} n'est pas valide")]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', message: "L'adresse email {{ value }} n'est pas valide")]
    private ?string $email = null;
    #[ORM\Column]
    #[Assert\NotBlank(message: "vous devez mettre le type!!!")]
    #[Assert\Length(min: 8, minMessage: "Le numéro doit comporter au minimum {{ limit }} chiffres")]
    private ?int $Numero = null;

    #[ORM\OneToMany(targetEntity: Dons::class, mappedBy: 'centreDon')]
    #[Assert\NotBlank(message:"vous devez mettre le type!!!")]
    private Collection $don;

    public function __construct()
    {
        $this->don = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCentre(): ?string
    {
        return $this->NomCentre;
    }

    public function setNomCentre(string $NomCentre): static
    {
        $this->NomCentre = $NomCentre;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->DateOuverture;
    }

    public function setDateOuverture(?\DateTimeInterface $DateOuverture): self
    {
        if ($DateOuverture !== null) {
            $this->DateOuverture = $DateOuverture;
        }

        return $this;
    }

    

    public function getDatefermeture(): ?\DateTimeInterface
    {
        return $this->datefermeture;
    }

    public function setDatefermeture(?\DateTimeInterface $datefermeture): self
    {
        $this->datefermeture = $datefermeture;

        return $this;
    }

    public function getGouvernorat(): ?string
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(string $gouvernorat): static
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): static
    {
        $this->Numero = $Numero;

        return $this;
    }

    /**
     * @return Collection<int, Dons>
     */
    public function getDon(): Collection
    {
        return $this->don;
    }

    public function addDon(Dons $don): static
    {
        if (!$this->don->contains($don)) {
            $this->don->add($don);
            $don->setCentreDon($this);
        }

        return $this;
    }

    public function removeDon(Dons $don): static
    {
        if ($this->don->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getCentreDon() === $this) {
                $don->setCentreDon(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->id . ' - ' . $this->NomCentre;
    }
}
