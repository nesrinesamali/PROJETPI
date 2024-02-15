<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $patient = null;

    #[ORM\Column(length: 255)]
    private ?string $doctor = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $medications = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instructions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pharmacy = null;

    #[ORM\ManyToMany(targetEntity: Dossiermedical::class, mappedBy: 'prescription')]
    private Collection $dossiermedicals;

    public function __construct()
    {
        $this->dossiermedicals = new ArrayCollection();
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

    public function getDoctor(): ?string
    {
        return $this->doctor;
    }

    public function setDoctor(string $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Dossiermedical>
     */
    public function getDossiermedicals(): Collection
    {
        return $this->dossiermedicals;
    }

    public function addDossiermedical(Dossiermedical $dossiermedical): static
    {
        if (!$this->dossiermedicals->contains($dossiermedical)) {
            $this->dossiermedicals->add($dossiermedical);
            $dossiermedical->addPrescription($this);
        }

        return $this;
    }

    public function removeDossiermedical(Dossiermedical $dossiermedical): static
    {
        if ($this->dossiermedicals->removeElement($dossiermedical)) {
            $dossiermedical->removePrescription($this);
        }

        return $this;
    }
}
