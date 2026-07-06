<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImagePrestationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImagePrestationRepository::class)]
#[ApiResource]
class ImagePrestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['prestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['prestation:read', 'prestation:write'])]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['prestation:read', 'prestation:write'])]
    private ?string $legende = null;

    #[ORM\ManyToOne(inversedBy: 'imagesModale')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestation $prestation = null;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): static
    {
        $this->legende = $legende;
        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): static
    {
        $this->prestation = $prestation;
        return $this;
    }
}