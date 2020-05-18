<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
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
    private $team;

 

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @ORM\ManyToOne(targetEntity=Pilote::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pilote;

    /**
     * @ORM\ManyToOne(targetEntity=GrandPrix::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grandPrix;

    /**
     * @ORM\Column(type="integer")
     */
    private $chrono;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getChrono(): ?\DateTimeInterface
    {
        return $this->chrono;
    }

    public function setChrono(\DateTimeInterface $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getPilote(): ?Pilote
    {
        return $this->pilote;
    }

    public function setPilote(?Pilote $pilote): self
    {
        $this->pilote = $pilote;

        return $this;
    }

    public function getGrandPrix(): ?GrandPrix
    {
        return $this->grandPrix;
    }

    public function setGrandPrix(?GrandPrix $grandPrix): self
    {
        $this->grandPrix = $grandPrix;

        return $this;
    }
}