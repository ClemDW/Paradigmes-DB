<?php

namespace toubeelib\praticien\core\Domaine\Entity;

use Doctrine\Common\Collections\Collection;

class Praticien{
    private String $id;
    private string $nom;
    private string $rpps_id;
    private string $prenom;
    private string $titre;
    private string $ville;
    private string $email;
    private string $telephone;
    private bool $organisation = false;
    private bool $accepte_nouveau_patient = true;
    private Specialite $specialite;
    private ?Structure $structure = null;
    private Collection $motifsVisite;
    private Collection $moyensPaiement;

    public function __construct(
        string $nom,
        string $rpps_id,
        string $prenom,
        string $titre,
        string $ville,
        string $email,
        string $telephone,
    )
    {
        $this->nom = $nom;
        $this->rpps_id = $rpps_id;
        $this->prenom = $prenom;
        $this->titre = $titre;
        $this->ville = $ville;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->motifsVisite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moyensPaiement = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getRppsId(): string
    {
        return $this->rpps_id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function isOrganisation(): bool
    {
        return $this->organisation;
    }

    public function accepteNouveauPatient(): bool
    {
        return $this->accepte_nouveau_patient;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function getMotifsVisite(): Collection
    {
        return $this->motifsVisite;
    }

    public function addMotifVisite(MotifVisite $motifVisite): self
    {
        if (!$this->motifsVisite->contains($motifVisite)) {
            $this->motifsVisite[] = $motifVisite;
        }
        return $this;
    }

    public function removeMotifVisite(MotifVisite $motifVisite): self
    {
        $this->motifsVisite->removeElement($motifVisite);
        return $this;
    }

    public function getMoyensPaiement(): Collection
    {
        return $this->moyensPaiement;
    }

    public function addMoyenPaiement(MoyenPaiement $moyenPaiement): self
    {
        if (!$this->moyensPaiement->contains($moyenPaiement)) {
            $this->moyensPaiement[] = $moyenPaiement;
        }
        return $this;
    }

    public function removeMoyenPaiement(MoyenPaiement $moyenPaiement): self
    {
        $this->moyensPaiement->removeElement($moyenPaiement);
        return $this;
    }




    // Setters
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setRppsId(string $rpps_id): self
    {
        $this->rpps_id = $rpps_id;
        return $this;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function setOrganisation(bool $organisation): self
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function setAccepteNouveauPatient(bool $accepte_nouveau_patient): self
    {
        $this->accepte_nouveau_patient = $accepte_nouveau_patient;
        return $this;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;
        return $this;
    }

}

