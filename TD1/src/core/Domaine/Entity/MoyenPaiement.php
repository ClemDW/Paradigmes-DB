<?php

namespace toubeelib\praticien\core\Domaine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class MoyenPaiement
{
    private int $id;
    private string $libelle;
    private Collection $praticiens;

    public function __construct(string $libelle)
    {
        $this->libelle = $libelle;
        $this->praticiens = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    public function addPraticien(Praticien $praticien): self
    {
        if (!$this->praticiens->contains($praticien)) {
            $this->praticiens[] = $praticien;
            $praticien->addMoyenPaiement($this);
        }
        return $this;
    }

    public function removePraticien(Praticien $praticien): self
    {
        if ($this->praticiens->removeElement($praticien)) {
            $praticien->removeMoyenPaiement($this);
        }
        return $this;
    }
}
