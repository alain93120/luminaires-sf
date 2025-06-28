<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mailerEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mailerName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMailerEmail(): ?string
    {
        return $this->mailerEmail;
    }

    public function setMailerEmail(string $mailerEmail): self
    {
        $this->mailerEmail = $mailerEmail;
        return $this;
    }

    public function getMailerName(): ?string
    {
        return $this->mailerName;
    }

    public function setMailerName(?string $mailerName): self
    {
        $this->mailerName = $mailerName;
        return $this;
    }
}
