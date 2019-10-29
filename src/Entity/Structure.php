<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StructureRepository")
 */
class Structure
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="decimal", precision=25, scale=20, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="decimal", precision=25, scale=20, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $information;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="integer")
     */
    private $typeStructure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $codeDepartement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville")
     * @ORM\JoinColumn(nullable=false)
     */
    private $codeCommune;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getTypeStructure(): ?int
    {
        return $this->typeStructure;
    }

    public function setTypeStructure(int $typeStructure): self
    {
        $this->typeStructure = $typeStructure;

        return $this;
    }

    public function getCodeDepartement(): ?Departement
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(?Departement $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getCodeCommune(): ?Ville
    {
        return $this->codeCommune;
    }

    public function setCodeCommune(?Ville $codeCommune): self
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }
}
