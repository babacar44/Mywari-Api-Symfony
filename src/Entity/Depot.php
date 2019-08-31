<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     * @Assert\GreaterThanOrEqual(
     *     value = 75000)
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepot;

  
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     */
    private $depot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots")
     */
    private $caissier;
//compte
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

   
//getCompte
    public function getDepot(): ?Compte
    {
        return $this->depot;
    }

    public function setDepot(?Compte $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getCaissier(): ?User
    {
        return $this->caissier;
    }

    public function setCaissier(?User $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }
}
