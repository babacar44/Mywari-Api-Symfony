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
     * @ORM\Column(type="string", length=255)
     */
    private $Envoyeur;

    /**
     * @ORM\Column(type="datetime", length=255)
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
     * @ORM\Column(type="string", length=255)
     */
    private $Destinataire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNI;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="operations")
     */
    private $user;

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

    public function getDateEnvoi(): ?string
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(string $dateEnvoi): self
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

    public function getCNI(): ?string
    {
        return $this->CNI;
    }

    public function setCNI(string $CNI): self
    {
        $this->CNI = $CNI;

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
}
