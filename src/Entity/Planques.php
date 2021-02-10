<?php

namespace App\Entity;

use App\Repository\PlanquesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanquesRepository::class)
 */
class Planques
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $postal;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=pays::class, inversedBy="planques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paysplanque;

    /**
     * @ORM\ManyToOne(targetEntity=typesplanques::class, inversedBy="planques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeplanque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

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

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(int $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPaysPlanque(): ?pays
    {
        return $this->paysplanque;
    }

    public function setPaysPlanque(?pays $paysplanque): self
    {
        $this->paysplanque = $paysplanque;

        return $this;
    }

    public function getTypeplanque(): ?typesplanques
    {
        return $this->typeplanque;
    }

    public function setTypeplanque(?typesplanques $typeplanque): self
    {
        $this->typeplanque = $typeplanque;

        return $this;
    }
}