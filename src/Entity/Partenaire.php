<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"post"}},
 * collectionOperations={
 *         "post"={
 * "security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])", "security_message"="Seul ADMIN_SYST peut creer un user"
 * }
 * }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
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
     * @Groups({"post","read"})
     */
    private $NomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post","read"})
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post","read"})
     */
    private $registreCommercial;

    /**
     * @ORM\Column(type="bigint")
     * @Groups({"post","read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post","read"})
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire", cascade={"persist"})
     * @Groups({"post","read"})
     */
    private $userComptePartenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="partenaireCreer")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post","read"})
     */
    private $userCreateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaire", cascade={"persist"})
     */
    private $comptes;

    public function __construct()
    {
        $this->userComptePartenaire = new ArrayCollection();
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->NomComplet;
    }

    public function setNomComplet(string $NomComplet): self
    {
        $this->NomComplet = $NomComplet;

        return $this;
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

    public function getRegistreCommercial(): ?string
    {
        return $this->registreCommercial;
    }

    public function setRegistreCommercial(string $registreCommercial): self
    {
        $this->registreCommercial = $registreCommercial;

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
     * @return Collection|User[]
     */
    public function getUserComptePartenaire(): Collection
    {
        return $this->userComptePartenaire;
    }

    public function addUserComptePartenaire(User $userComptePartenaire): self
    {
        if (!$this->userComptePartenaire->contains($userComptePartenaire)) {
            $this->userComptePartenaire[] = $userComptePartenaire;
            $userComptePartenaire->setPartenaire($this);
        }

        return $this;
    }

    public function removeUserComptePartenaire(User $userComptePartenaire): self
    {
        if ($this->userComptePartenaire->contains($userComptePartenaire)) {
            $this->userComptePartenaire->removeElement($userComptePartenaire);
            // set the owning side to null (unless already changed)
            if ($userComptePartenaire->getPartenaire() === $this) {
                $userComptePartenaire->setPartenaire(null);
            }
        }

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
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setPartenaire($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaire() === $this) {
                $compte->setPartenaire(null);
            }
        }

        return $this;
    }
}
