<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
#[ApiResource(
    operations: [

        new Get(normalizationContext: ['groups' => ['tarif:read', 'tarif:detail']]), 
        new GetCollection(normalizationContext: ['groups' => ['tarif:read']]),
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
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $titreBloc = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $prix = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $texteTarifs = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tarif:read', 'tarif:write'])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'tarif', targetEntity: GalleryImageModale::class, cascade: ['persist', 'remove'], orphanRemoval: true,
    fetch: "EAGER"
    )]

    #[Groups(['tarif:detail'])] //
    private Collection $imagesGalerie;

    public function __construct()
    {
        $this->imagesGalerie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreBloc(): ?string
    {
        return $this->titreBloc;
    }

    public function setTitreBloc(string $titreBloc): self
    {
        $this->titreBloc = $titreBloc;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getTexteTarifs(): ?string
    {
        return $this->texteTarifs;
    }

    public function setTexteTarifs(string $texteTarifs): self
    {
        $this->texteTarifs = $texteTarifs;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Collection<int, GalleryImageModale>
     */
    public function getImagesGalerie(): Collection
    {
        return $this->imagesGalerie;
    }

    public function addImagesGalerie(GalleryImageModale $imagesGalerie): self
    {
        if (!$this->imagesGalerie->contains($imagesGalerie)) {
            $this->imagesGalerie->add($imagesGalerie);
            $imagesGalerie->setTarif($this);
        }

        return $this;
    }

    public function removeImagesGalerie(GalleryImageModale $imagesGalerie): self
    {
        if ($this->imagesGalerie->removeElement($imagesGalerie)) {
            if ($imagesGalerie->getTarif() === $this) {
                $imagesGalerie->setTarif(null);
            }
        }

        return $this;
    }
}