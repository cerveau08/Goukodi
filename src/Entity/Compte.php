<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"post"}},
 *  collectionOperations={
 *         "post"={
 * "security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])", "security_message"="Seul ADMIN_SYST peut creer un user"
 * }
 *     },
 * itemOperations={
 *      "GET"={
 * "security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])"}
 * }  )
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
     * @Groups({"post","read"})
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post","read"})
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptesCreer")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private $userCreateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte", cascade={"persist"})
     * @Groups({"post","read"})
     */
    private $depots;

    /**
     * @ORM\Column(type="float")
     * @Groups({"post","read"})
     */
    private $solde;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="compteAffecter")
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="compteEmetteur")
     */
    private $transactionEnvoyer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="compteRecepteur")
     */
    private $transactionRecu;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->transactionEnvoyer = new ArrayCollection();
        $this->transactionRecu = new ArrayCollection();
        $this->dateCreation=  new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getUserCreateur(): ?User
    {
        return $this->userCreateur;
    }

    public function setUserCreateur(?User $userCreateur): self
    {
        $this->userCreateur = $userCreateur;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setCompteAffecter($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getCompteAffecter() === $this) {
                $affectation->setCompteAffecter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionEnvoyer(): Collection
    {
        return $this->transactionEnvoyer;
    }

    public function addTransactionEnvoyer(Transaction $transactionEnvoyer): self
    {
        if (!$this->transactionEnvoyer->contains($transactionEnvoyer)) {
            $this->transactionEnvoyer[] = $transactionEnvoyer;
            $transactionEnvoyer->setCompteEmetteur($this);
        }

        return $this;
    }

    public function removeTransactionEnvoyer(Transaction $transactionEnvoyer): self
    {
        if ($this->transactionEnvoyer->contains($transactionEnvoyer)) {
            $this->transactionEnvoyer->removeElement($transactionEnvoyer);
            // set the owning side to null (unless already changed)
            if ($transactionEnvoyer->getCompteEmetteur() === $this) {
                $transactionEnvoyer->setCompteEmetteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionRecu(): Collection
    {
        return $this->transactionRecu;
    }

    public function addTransactionRecu(Transaction $transactionRecu): self
    {
        if (!$this->transactionRecu->contains($transactionRecu)) {
            $this->transactionRecu[] = $transactionRecu;
            $transactionRecu->setCompteRecepteur($this);
        }

        return $this;
    }

    public function removeTransactionRecu(Transaction $transactionRecu): self
    {
        if ($this->transactionRecu->contains($transactionRecu)) {
            $this->transactionRecu->removeElement($transactionRecu);
            // set the owning side to null (unless already changed)
            if ($transactionRecu->getCompteRecepteur() === $this) {
                $transactionRecu->setCompteRecepteur(null);
            }
        }

        return $this;
    }
}
