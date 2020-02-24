<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientRecepteur;

    /**
     * @ORM\Column(type="bigint")
     */
    private $telephoneEmetteur;

    /**
     * @ORM\Column(type="bigint")
     */
    private $telephoneRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typePieceEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPieceEmetteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typePieceRecepteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroPieceRecepteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactionEnvoyer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userEmetteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transctionRecu")
     */
    private $userRecepteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactionEnvoyer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteEmetteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactionRecu")
     */
    private $compteRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $taxeEtat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commissionEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commissionRecepteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getClientEmetteur(): ?string
    {
        return $this->clientEmetteur;
    }

    public function setClientEmetteur(string $clientEmetteur): self
    {
        $this->clientEmetteur = $clientEmetteur;

        return $this;
    }

    public function getClientRecepteur(): ?string
    {
        return $this->clientRecepteur;
    }

    public function setClientRecepteur(string $clientRecepteur): self
    {
        $this->clientRecepteur = $clientRecepteur;

        return $this;
    }

    public function getTelephoneEmetteur(): ?string
    {
        return $this->telephoneEmetteur;
    }

    public function setTelephoneEmetteur(string $telephoneEmetteur): self
    {
        $this->telephoneEmetteur = $telephoneEmetteur;

        return $this;
    }

    public function getTelephoneRecepteur(): ?string
    {
        return $this->telephoneRecepteur;
    }

    public function setTelephoneRecepteur(string $telephoneRecepteur): self
    {
        $this->telephoneRecepteur = $telephoneRecepteur;

        return $this;
    }

    public function getTypePieceEmetteur(): ?string
    {
        return $this->typePieceEmetteur;
    }

    public function setTypePieceEmetteur(string $typePieceEmetteur): self
    {
        $this->typePieceEmetteur = $typePieceEmetteur;

        return $this;
    }

    public function getNumeroPieceEmetteur(): ?string
    {
        return $this->numeroPieceEmetteur;
    }

    public function setNumeroPieceEmetteur(string $numeroPieceEmetteur): self
    {
        $this->numeroPieceEmetteur = $numeroPieceEmetteur;

        return $this;
    }

    public function getTypePieceRecepteur(): ?string
    {
        return $this->typePieceRecepteur;
    }

    public function setTypePieceRecepteur(string $typePieceRecepteur): self
    {
        $this->typePieceRecepteur = $typePieceRecepteur;

        return $this;
    }

    public function getNumeroPieceRecepteur(): ?string
    {
        return $this->numeroPieceRecepteur;
    }

    public function setNumeroPieceRecepteur(string $numeroPieceRecepteur): self
    {
        $this->numeroPieceRecepteur = $numeroPieceRecepteur;

        return $this;
    }

    public function getUserEmetteur(): ?User
    {
        return $this->userEmetteur;
    }

    public function setUserEmetteur(?User $userEmetteur): self
    {
        $this->userEmetteur = $userEmetteur;

        return $this;
    }

    public function getUserRecepteur(): ?User
    {
        return $this->userRecepteur;
    }

    public function setUserRecepteur(?User $userRecepteur): self
    {
        $this->userRecepteur = $userRecepteur;

        return $this;
    }

    public function getCompteEmetteur(): ?Compte
    {
        return $this->compteEmetteur;
    }

    public function setCompteEmetteur(?Compte $compteEmetteur): self
    {
        $this->compteEmetteur = $compteEmetteur;

        return $this;
    }

    public function getCompteRecepteur(): ?Compte
    {
        return $this->compteRecepteur;
    }

    public function setCompteRecepteur(?Compte $compteRecepteur): self
    {
        $this->compteRecepteur = $compteRecepteur;

        return $this;
    }

    public function getTaxeEtat(): ?string
    {
        return $this->taxeEtat;
    }

    public function setTaxeEtat(string $taxeEtat): self
    {
        $this->taxeEtat = $taxeEtat;

        return $this;
    }

    public function getCommissionSysteme(): ?string
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(string $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getCommissionEmetteur(): ?string
    {
        return $this->commissionEmetteur;
    }

    public function setCommissionEmetteur(string $commissionEmetteur): self
    {
        $this->commissionEmetteur = $commissionEmetteur;

        return $this;
    }

    public function getCommissionRecepteur(): ?string
    {
        return $this->commissionRecepteur;
    }

    public function setCommissionRecepteur(string $commissionRecepteur): self
    {
        $this->commissionRecepteur = $commissionRecepteur;

        return $this;
    }
}
