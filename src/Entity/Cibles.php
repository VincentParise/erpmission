<?php

namespace App\Entity;

use App\Repository\CiblesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CiblesRepository::class)
 */
class Cibles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=pays::class, inversedBy="cibles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payscible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
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

    public function getPayscible(): ?pays
    {
        return $this->payscible;
    }

    public function setPayscible(?pays $payscible): self
    {
        $this->payscible = $payscible;

        return $this;
    }
}
