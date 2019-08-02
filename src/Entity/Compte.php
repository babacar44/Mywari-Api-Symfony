<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
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
    private $compteBancaire;

    /**
     * @ORM\Column(type="bigint")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="category")
     */
    private $idPartenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Depot", inversedBy="comptes")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteBancaire(): ?string
    {
        return $this->compteBancaire;
    }

    public function setCompteBancaire(string $compteBancaire): self
    {
        $this->compteBancaire = $compteBancaire;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getIdPartenaire(): ?Partenaire
    {
        return $this->idPartenaire;
    }

    public function setIdPartenaire(?Partenaire $idPartenaire): self
    {
        $this->idPartenaire = $idPartenaire;

        return $this;
    }

    public function getCategory(): ?Depot
    {
        return $this->category;
    }

    public function setCategory(?Depot $category): self
    {
        $this->category = $category;

        return $this;
    }
}
