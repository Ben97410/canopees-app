<?php

namespace App\Entity;

use App\Repository\GalleryImageModaleRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GalleryImageModaleRepository::class)]
#[ApiResource]
class GalleryImageModale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tarif:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'imagesGalerie')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Tarif $tarif = null;

    
    public function __toString(): string
    {
        return $this->image ?? 'Nouvelle image';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getTarif(): ?Tarif
    {
        return $this->tarif;
    }

    public function setTarif(?Tarif $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }
}