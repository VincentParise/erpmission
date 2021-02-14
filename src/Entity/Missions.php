<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity=Typesmissions::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typemission;

    /**
     * @ORM\ManyToOne(targetEntity=Statutsmissions::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statutmission;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paysmission;

    /**
     * @ORM\ManyToOne(targetEntity=Specialites::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialitemission;

    /**
     * @ORM\ManyToMany(targetEntity=Cibles::class, inversedBy="missions")
     */
    private $cibles;

    /**
     * @ORM\ManyToMany(targetEntity=Planques::class, inversedBy="missions")
     */
    private $planques;



    /**
     * @ORM\ManyToMany(targetEntity=Contacts::class, inversedBy="missions")
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity=Agents::class, mappedBy="missions")
     */
    private $agents;


    public function __construct()
    {
        $this->cibles = new ArrayCollection();
        $this->planques = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->contacts = new ArrayCollection();

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
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        $this->contacts->removeElement($contact);

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
            $agent->addMission($this);
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            $agent->removeMission($this);
        }

        return $this;
    }

}
