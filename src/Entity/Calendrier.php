<?php
// src/Entity/Calendrier.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 * @ORM\Table(name="calendrier")
 * @ORM\Entity(repositoryClass="App\Repository\CalendrierRepository")
 */
class Calendrier
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
     * @ORM\Column(name="jour_feries",type="integer")
     */
    private $jourFeries;

    /**
     * @ORM\Column(type="text")
     */
    private $infos;

    /**
     * @ORM\Column(type="text")
     */
    private $disponibilite;

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

    public function getJourFeries(): ?int
    {
        return $this->jourFeries;
    }

    public function setJourFeries(int $jourFeries): self
    {
        $this->jourFeries = $jourFeries;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }
}