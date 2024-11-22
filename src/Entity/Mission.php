<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(enumType: MissionStatus::class)]
    private ?MissionStatus $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $dangerLevel = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?Team $assignedTeam = null;

    #[ORM\OneToOne(mappedBy: 'currentMission', cascade: ['persist', 'remove'])]
    private ?Team $team = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getStatus(): ?MissionStatus
    {
        return $this->status;
    }

    public function setStatus(MissionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDangerLevel(): ?int
    {
        return $this->dangerLevel;
    }

    public function setDangerLevel(int $dangerLevel): static
    {
        $this->dangerLevel = $dangerLevel;

        return $this;
    }

    public function getAssignedTeam(): ?Team
    {
        return $this->assignedTeam;
    }

    public function setAssignedTeam(?Team $assignedTeam): static
    {
        $this->assignedTeam = $assignedTeam;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        // unset the owning side of the relation if necessary
        if ($team === null && $this->team !== null) {
            $this->team->setCurrentMission(null);
        }

        // set the owning side of the relation if necessary
        if ($team !== null && $team->getCurrentMission() !== $this) {
            $team->setCurrentMission($this);
        }

        $this->team = $team;

        return $this;
    }
}
