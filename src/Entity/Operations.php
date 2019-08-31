<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationsRepository")
 */
class Operations
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
    private $CodeEnvoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Envoyeur;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="integer")
     */
    private $Montant;

    /**
     * @ORM\Column(type="integer")
     */
    private $commission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Destinataire;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="operations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="operations")
     */
    private $compte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cniEnvoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cniRecepteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telEnvoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telRecepteur;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\Column(type="integer")
     */
    private $wari;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $comEnvoi;

    /**
     * @ORM\Column(type="integer")
     */
    private $comRetrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeEnvoi(): ?string
    {
        return $this->CodeEnvoi;
    }

    public function setCodeEnvoi(string $CodeEnvoi): self
    {
        $this->CodeEnvoi = $CodeEnvoi;

        return $this;
    }

    public function getEnvoyeur(): ?string
    {
        return $this->Envoyeur;
    }

    public function setEnvoyeur(string $Envoyeur): self
    {
        $this->Envoyeur = $Envoyeur;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->Montant;
    }

    public function setMontant(int $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getCommission(): ?int
    {
        return $this->commission;
    }

    public function setCommission(int $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function getDestinataire(): ?string
    {
        return $this->Destinataire;
    }

    public function setDestinataire(string $Destinataire): self
    {
        $this->Destinataire = $Destinataire;

        return $this;
    }

   

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getCniEnvoyeur(): ?string
    {
        return $this->cniEnvoyeur;
    }

    public function setCniEnvoyeur(string $cniEnvoyeur): self
    {
        $this->cniEnvoyeur = $cniEnvoyeur;

        return $this;
    }

    public function getCniRecepteur(): ?string
    {
        return $this->cniRecepteur;
    }

    public function setCniRecepteur(string $cniRecepteur): self
    {
        $this->cniRecepteur = $cniRecepteur;

        return $this;
    }

    public function getTelEnvoyeur(): ?string
    {
        return $this->telEnvoyeur;
    }

    public function setTelEnvoyeur(string $telEnvoyeur): self
    {
        $this->telEnvoyeur = $telEnvoyeur;

        return $this;
    }

    public function getTelRecepteur(): ?string
    {
        return $this->telRecepteur;
    }

    public function setTelRecepteur(string $telRecepteur): self
    {
        $this->telRecepteur = $telRecepteur;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getWari(): ?int
    {
        return $this->wari;
    }

    public function setWari(int $wari): self
    {
        $this->wari = $wari;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getComEnvoi(): ?int
    {
        return $this->comEnvoi;
    }

    public function setComEnvoi(int $comEnvoi): self
    {
        $this->comEnvoi = $comEnvoi;

        return $this;
    }

    public function getComRetrait(): ?int
    {
        return $this->comRetrait;
    }

    public function setComRetrait(int $comRetrait): self
    {
        $this->comRetrait = $comRetrait;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    
}
