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
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="paysuser")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Missions::class, mappedBy="paysmission")
     */
    private $missions;

    public function __construct()
    {
        $this->planques = new ArrayCollection();
        $this->cibles = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->missions = new ArrayCollection();
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
            $user->setPaysuser($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPaysuser() === $this) {
                $user->setPaysuser(null);
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
}
