<?php

namespace App\Entity;

use App\Repository\InfluencersRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: InfluencersRepository::class)]
class Influencers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $followers_count = null;

    #[ORM\ManyToMany(targetEntity: Campana::class, mappedBy: 'influencers')]
    private Collection $campanas;

    public function __construct()
    {
        $this->campanas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFollowersCount(): ?int
    {
        return $this->followers_count;
    }

    public function setFollowersCount(?int $followers_count): static
    {
        $this->followers_count = $followers_count;

        return $this;
    }

    /**
     * @return Collection<int, Campana>
     */
    public function getCampaigns(): Collection
    {
        return $this->campanas;
    }

    public function addCampaign(Campana $campaign): static
    {
        if (!$this->campanas->contains($campaign)) {
            $this->campanas->add($campaign);
            $campaign->addInfluencer($this);
        }

        return $this;
    }

    public function removeCampaign(Campana $campaign): static
    {
        if ($this->campanas->removeElement($campaign)) {
            $campaign->removeInfluencer($this);
        }

        return $this;
    }
}
