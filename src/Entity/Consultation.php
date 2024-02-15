<?php
// src/Entity/Consultation.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="App\Repository\ConsultationRepository")
 */

class Consultation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_medecin",type="integer")
     */
    private $idMedecin;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPatients;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    /**
     * @ORM\Column(type="text")
     */
    private $diagnostique;

    /**
     * @ORM\Column(type="text")
     */
    private $recommandations;

    // Ajoutez les getters et setters générés automatiquement par Doctrine

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(int $idMedecin): self
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }

    public function getIdPatients(): ?int
    {
        return $this->idPatients;
    }

    public function setIdPatients(int $idPatients): self
    {
        $this->idPatients = $idPatients;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDiagnostique(): ?string
    {
        return $this->diagnostique;
    }

    public function setDiagnostique(string $diagnostique): self
    {
        $this->diagnostique = $diagnostique;

        return $this;
    }

    public function getRecommandations(): ?string
    {
        return $this->recommandations;
    }

    public function setRecommandations(string $recommandations): self
    {
        $this->recommandations = $recommandations;

        return $this;
    }
}