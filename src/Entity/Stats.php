<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StatsRepository;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="string", length=255)
     * @ORM\OrderBy({"order" = "ASC", "id" = "ASC"})
     */
    private $chrono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;



    /**
     * Permet d'intialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->id);
        }

    }
  

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

    public function getChrono()
    {
        return $this->chrono;
    }

    public function setChrono($chrono)
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    
}
