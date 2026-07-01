<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TarifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
#[ApiResource(
    operations: [
        new Get(), 
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['tarif:read']],
    denormalizationContext: ['groups' => ['tarif:write']]
)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tarif:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $titreBloc = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $texteTarifs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreBloc(): ?string
    {
        return $this->titreBloc;
    }

    public function setTitreBloc(string $titreBloc): static
    {
        $this->titreBloc = $titreBloc;
        return $this;
    }

    public function getTexteTarifs(): ?string
    {
        return $this->texteTarifs;
    }

    public function setTexteTarifs(string $texteTarifs): static
    {
        $this->texteTarifs = $texteTarifs;
        return $this;
    }
}