<?php

namespace toubeelib\praticien\core\Domaine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class MotifVisite
{
    private int $id;
    private string $libelle;
    private Specialite $specialite;
    private Collection $praticiens;

    public function __construct(string $libelle, Specialite $specialite)
    {
        $this->libelle = $libelle;
        $this->specialite = $specialite;
        $this->praticiens = new ArrayCollection();
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    // Setters
    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    // Gestion de la relation ManyToMany
    public function addPraticien(Praticien $praticien): self
    {
        if (!$this->praticiens->contains($praticien)) {
            $this->praticiens[] = $praticien;
            $praticien->addMotifVisite($this);
        }
        return $this;
    }

    public function removePraticien(Praticien $praticien): self
    {
        if ($this->praticiens->removeElement($praticien)) {
            $praticien->removeMotifVisite($this);
        }
        return $this;
    }
}