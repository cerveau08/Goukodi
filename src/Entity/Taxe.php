<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TaxeRepository")
 */
class Taxe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionEnvoie;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionRetrait;

    /**
     * @ORM\Column(type="float")
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="float")
     */
    private $taxeEtat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommissionEnvoie(): ?float
    {
        return $this->commissionEnvoie;
    }

    public function setCommissionEnvoie(float $commissionEnvoie): self
    {
        $this->commissionEnvoie = $commissionEnvoie;

        return $this;
    }

    public function getCommissionRetrait(): ?float
    {
        return $this->commissionRetrait;
    }

    public function setCommissionRetrait(float $commissionRetrait): self
    {
        $this->commissionRetrait = $commissionRetrait;

        return $this;
    }

    public function getCommissionSysteme(): ?float
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(float $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getTaxeEtat(): ?float
    {
        return $this->taxeEtat;
    }

    public function setTaxeEtat(float $taxeEtat): self
    {
        $this->taxeEtat = $taxeEtat;

        return $this;
    }
}
