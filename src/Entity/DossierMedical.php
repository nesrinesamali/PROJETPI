<?php

namespace App\Entity;

use App\Repository\DossierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DossierMedicalRepository::class)]
class DossierMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, minMessage: "Votre message personnalisé pour la longueur minimale")]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]*$/')]
    private ?string $patient = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Assert\Length(min: 10)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $diagnosis = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $test = null;

    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'dossierMedical')]
    private Collection $Prescription;

    #[ORM\OneToOne(inversedBy: 'dossierMedical', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    

    public function __construct()
    {
        $this->Prescription = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?string
    {
        return $this->patient;
    }

    public function setPatient(string $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

   

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDiagnosis(): ?string
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(string $diagnosis): static
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    public function getTest(): ?string
    {
        return $this->test;
    }

    public function setTest(?string $test): static
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescription(): Collection
    {
        return $this->Prescription;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->Prescription->contains($prescription)) {
            $this->Prescription->add($prescription);
            $prescription->setDossierMedical($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->Prescription->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getDossierMedical() === $this) {
                $prescription->setDossierMedical(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

 
}