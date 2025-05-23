<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\CampanaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: CampanaRepository::class)]
class Campana
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $start_date = null;

    #[ORM\Column]
    private ?\DateTime $end_date = null;

    #[ORM\ManyToMany(targetEntity: Influencers::class, inversedBy: 'campaigns')]
    #[ORM\JoinTable(name: 'campaign_influencer')] // Especifica o nome da tabela
    private Collection $influencers;

    public function __construct()
    {
        $this->influencers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName() ?? 'Campaña sin nombre';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Influencers>
     */
    public function getInfluencers(): Collection
    {
        return $this->influencers;
    }

    public function addInfluencer(Influencers $influencer): static
    {
        if (!$this->influencers->contains($influencer)) {
            $this->influencers->add($influencer);
        }

        return $this;
    }

    public function removeInfluencer(Influencers $influencer): static
    {
        $this->influencers->removeElement($influencer);

        return $this;
    }
}
