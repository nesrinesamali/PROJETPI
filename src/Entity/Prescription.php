<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]*$/')]

    private ?string $patient = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]*$/')]
    private ?string $doctor = null;

    #[ORM\Column]
    private ?\DateTime $Created_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $medications = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $instructions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pharmacy = null;

    #[ORM\ManyToOne(inversedBy: 'Prescription')]
    private ?DossierMedical $dossierMedical = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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

    public function getDoctor(): ?string
    {
        return $this->doctor;
    }

    public function setDoctor(string $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTime $Created_at): static
    {
        $this->Created_at = $Created_at;

        return $this;
    }

    public function getMedications(): ?string
    {
        return $this->medications;
    }

    public function setMedications(?string $medications): static
    {
        $this->medications = $medications;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getPharmacy(): ?string
    {
        return $this->pharmacy;
    }

    public function setPharmacy(?string $pharmacy): static
    {
        $this->pharmacy = $pharmacy;

        return $this;
    }

    public function getDossierMedical(): ?DossierMedical
    {
        return $this->dossierMedical;
    }

    public function setDossierMedical(?DossierMedical $dossierMedical): static
    {
        $this->dossierMedical = $dossierMedical;

        return $this;
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
