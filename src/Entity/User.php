<?php

namespace App\Entity;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Entity\Affectation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"post"}},
 * collectionOperations={
 *          "post"={"access_control"="is_granted('POST', object)"}
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="Cet utulisateur existe déjà")
 * @UniqueEntity(fields={"email"}, message="Cet email existe déjà")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post","read"})
     */
    private $email;

    /**
     *  @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Groups({"post","read"})
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post","read"})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="userComptePartenaire")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="userCreateur")
     */
    private $partenaireCreer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="userCreateur")
     */
    private $comptesCreer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="caissierAdd")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="userCompte")
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userEmetteur")
     */
    private $transactionEnvoyer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userRecepteur")
     */
    private $transctionRecu;

    public function __construct()
    {
        $this->isActive = true;
        $this->partenaireCreer = new ArrayCollection();
        $this->comptesCreer = new ArrayCollection();
        $this->depots = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->transactionEnvoyer = new ArrayCollection();
        $this->transctionRecu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        $roles[] = strtoupper($this->profil->getLibelle());
       return array_unique($roles); 
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

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

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

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaireCreer(): Collection
    {
        return $this->partenaireCreer;
    }

    public function addPartenaireCreer(Partenaire $partenaireCreer): self
    {
        if (!$this->partenaireCreer->contains($partenaireCreer)) {
            $this->partenaireCreer[] = $partenaireCreer;
            $partenaireCreer->setUserCreateur($this);
        }

        return $this;
    }

    public function removePartenaireCreer(Partenaire $partenaireCreer): self
    {
        if ($this->partenaireCreer->contains($partenaireCreer)) {
            $this->partenaireCreer->removeElement($partenaireCreer);
            // set the owning side to null (unless already changed)
            if ($partenaireCreer->getUserCreateur() === $this) {
                $partenaireCreer->setUserCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptesCreer(): Collection
    {
        return $this->comptesCreer;
    }

    public function addComptesCreer(Compte $comptesCreer): self
    {
        if (!$this->comptesCreer->contains($comptesCreer)) {
            $this->comptesCreer[] = $comptesCreer;
            $comptesCreer->setUserCreateur($this);
        }

        return $this;
    }

    public function removeComptesCreer(Compte $comptesCreer): self
    {
        if ($this->comptesCreer->contains($comptesCreer)) {
            $this->comptesCreer->removeElement($comptesCreer);
            // set the owning side to null (unless already changed)
            if ($comptesCreer->getUserCreateur() === $this) {
                $comptesCreer->setUserCreateur(null);
            }
        }

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
            $depot->setCaissierAdd($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCaissierAdd() === $this) {
                $depot->setCaissierAdd(null);
            }
        }

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
            $affectation->setUserCompte($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getUserCompte() === $this) {
                $affectation->setUserCompte(null);
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
            $transactionEnvoyer->setUserEmetteur($this);
        }

        return $this;
    }

    public function removeTransactionEnvoyer(Transaction $transactionEnvoyer): self
    {
        if ($this->transactionEnvoyer->contains($transactionEnvoyer)) {
            $this->transactionEnvoyer->removeElement($transactionEnvoyer);
            // set the owning side to null (unless already changed)
            if ($transactionEnvoyer->getUserEmetteur() === $this) {
                $transactionEnvoyer->setUserEmetteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransctionRecu(): Collection
    {
        return $this->transctionRecu;
    }

    public function addTransctionRecu(Transaction $transctionRecu): self
    {
        if (!$this->transctionRecu->contains($transctionRecu)) {
            $this->transctionRecu[] = $transctionRecu;
            $transctionRecu->setUserRecepteur($this);
        }

        return $this;
    }

    public function removeTransctionRecu(Transaction $transctionRecu): self
    {
        if ($this->transctionRecu->contains($transctionRecu)) {
            $this->transctionRecu->removeElement($transctionRecu);
            // set the owning side to null (unless already changed)
            if ($transctionRecu->getUserRecepteur() === $this) {
                $transctionRecu->setUserRecepteur(null);
            }
        }

        return $this;
    }
}
