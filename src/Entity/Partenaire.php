<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * 
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @UniqueEntity("telephone")
 * @UniqueEntity("raisonSociale")
 */
class Partenaire
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
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "raisonSociale cannot be empty.")
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message = "nomComplet cannot be empty.")
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="bigint", length=255)
     * @Assert\NotBlank(message = "telephone cannot be empty.")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre")
     * 
     */
    private $telephone;

    /**
     *@Assert\Email(message = "Email n'est pas bon.")
     * @Assert\NotBlank(message = "Email cannot be empty.")
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "adresse cannot be empty.")
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaire")
     */
    private $partenaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    
   
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getPartenaire(): Collection
    {
        return $this->partenaire;
    }

    public function addPartenaire(Compte $partenaire): self
    {
        if (!$this->partenaire->contains($partenaire)) {
            $this->partenaire[] = $partenaire;
            $partenaire->setPartenaire($this);
        }

        return $this;
    }

    public function removePartenaire(Compte $partenaire): self
    {
        if ($this->partenaire->contains($partenaire)) {
            $this->partenaire->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getPartenaire() === $this) {
                $partenaire->setPartenaire(null);
            }
        }

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPartenaire($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPartenaire() === $this) {
                $user->setPartenaire(null);
            }
        }

        return $this;
    }

    

   
}
