<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 */
class Pays
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
     * @ORM\Column(type="string", length=100)
     */
    private $nationalite;

    /**
     * @ORM\OneToMany(targetEntity=Planques::class, mappedBy="paysplanque")
     */
    private $planques;

    /**
     * @ORM\OneToMany(targetEntity=Cibles::class, mappedBy="payscible")
     */
    private $cibles;


    /**
     * @ORM\OneToMany(targetEntity=Missions::class, mappedBy="paysmission")
     */
    private $missions;

    /**
     * @ORM\OneToMany(targetEntity=Contacts::class, mappedBy="pays")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Agents::class, mappedBy="pays")
     */
    private $agents;

    public function __construct()
    {
        $this->planques = new ArrayCollection();
        $this->cibles = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->agents = new ArrayCollection();
    }

    public function __toString() {
        return $this->getLibelle();
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

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

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
            $planque->setPaysPlanque($this);
        }

        return $this;
    }

    public function removePlanque(Planques $planque): self
    {
        if ($this->planques->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getPaysPlanque() === $this) {
                $planque->setPaysPlanque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cibles[]
     */
    public function getCibles(): Collection
    {
        return $this->cibles;
    }

    public function addCible(Cibles $cible): self
    {
        if (!$this->cibles->contains($cible)) {
            $this->cibles[] = $cible;
            $cible->setPayscible($this);
        }

        return $this;
    }

    public function removeCible(Cibles $cible): self
    {
        if ($this->cibles->removeElement($cible)) {
            // set the owning side to null (unless already changed)
            if ($cible->getPayscible() === $this) {
                $cible->setPayscible(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Missions[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Missions $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setPaysmission($this);
        }

        return $this;
    }

    public function removeMission(Missions $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getPaysmission() === $this) {
                $mission->setPaysmission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contacts[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setPays($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getPays() === $this) {
                $contact->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Agents[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agents $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setPays($this);
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getPays() === $this) {
                $agent->setPays(null);
            }
        }

        return $this;
    }
}
