<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionsRepository::class)
 */
class Missions
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $codename;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datestart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateend;

    /**
     * @ORM\ManyToOne(targetEntity=typesmissions::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typemission;

    /**
     * @ORM\ManyToOne(targetEntity=statutsmissions::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statutmission;

    /**
     * @ORM\ManyToOne(targetEntity=pays::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paysmission;

    /**
     * @ORM\ManyToOne(targetEntity=specialites::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialitemission;

    /**
     * @ORM\ManyToMany(targetEntity=cibles::class, inversedBy="missions")
     */
    private $cibles;

    /**
     * @ORM\ManyToMany(targetEntity=planques::class, inversedBy="missions")
     */
    private $planques;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="missions")
     */
    private $users;

    public function __construct()
    {
        $this->cibles = new ArrayCollection();
        $this->planques = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCodename(): ?string
    {
        return $this->codename;
    }

    public function setCodename(string $codename): self
    {
        $this->codename = $codename;

        return $this;
    }

    public function getDatestart(): ?\DateTimeInterface
    {
        return $this->datestart;
    }

    public function setDatestart(\DateTimeInterface $datestart): self
    {
        $this->datestart = $datestart;

        return $this;
    }

    public function getDateend(): ?\DateTimeInterface
    {
        return $this->dateend;
    }

    public function setDateend(\DateTimeInterface $dateend): self
    {
        $this->dateend = $dateend;

        return $this;
    }

    public function getTypemission(): ?typesmissions
    {
        return $this->typemission;
    }

    public function setTypemission(?typesmissions $typemission): self
    {
        $this->typemission = $typemission;

        return $this;
    }

    public function getStatutmission(): ?statutsmissions
    {
        return $this->statutmission;
    }

    public function setStatutmission(?statutsmissions $statutmission): self
    {
        $this->statutmission = $statutmission;

        return $this;
    }

    public function getPaysmission(): ?pays
    {
        return $this->paysmission;
    }

    public function setPaysmission(?pays $paysmission): self
    {
        $this->paysmission = $paysmission;

        return $this;
    }

    public function getSpecialitemission(): ?specialites
    {
        return $this->specialitemission;
    }

    public function setSpecialitemission(?specialites $specialitemission): self
    {
        $this->specialitemission = $specialitemission;

        return $this;
    }

    /**
     * @return Collection|cibles[]
     */
    public function getCibles(): Collection
    {
        return $this->cibles;
    }

    public function addCible(cibles $cible): self
    {
        if (!$this->cibles->contains($cible)) {
            $this->cibles[] = $cible;
        }

        return $this;
    }

    public function removeCible(cibles $cible): self
    {
        $this->cibles->removeElement($cible);

        return $this;
    }

    /**
     * @return Collection|planques[]
     */
    public function getPlanques(): Collection
    {
        return $this->planques;
    }

    public function addPlanque(planques $planque): self
    {
        if (!$this->planques->contains($planque)) {
            $this->planques[] = $planque;
        }

        return $this;
    }

    public function removePlanque(planques $planque): self
    {
        $this->planques->removeElement($planque);

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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
