<?php

namespace App\Entity;

use App\Repository\TypesplanquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesplanquesRepository::class)
 */
class Typesplanques
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Planques::class, mappedBy="typeplanque")
     */
    private $planques;

    public function __construct()
    {
        $this->planques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Planques[]
     */
    public function getPlanques(): Collection
    {
        return $this->planques;
    }

    public function addPlanque(Planques $planque): self
    {
        if (!$this->planques->contains($planque)) {
            $this->planques[] = $planque;
            $planque->setTypeplanque($this);
        }

        return $this;
    }

    public function removePlanque(Planques $planque): self
    {
        if ($this->planques->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getTypeplanque() === $this) {
                $planque->setTypeplanque(null);
            }
        }

        return $this;
    }
}
