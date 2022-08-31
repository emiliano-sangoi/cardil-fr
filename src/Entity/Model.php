<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ModelRepository::class)]
#[ORM\Table(name: "models")]
#[ORM\UniqueConstraint(name: 'uk_models', columns: ['nom', 'type_transport'])]
class Model implements \JsonSerializable
{
    const ETAT_OUI = 1;
    const ETAT_NON = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 1)]
    private ?string $typeTransport = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\Column]
    private ?int $ordre = 0;

    #[ORM\ManyToOne(inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeTransport(): ?string
    {
        return $this->typeTransport;
    }

    public function setTypeTransport(string $typeTransport): self
    {
        $this->typeTransport = $typeTransport;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'typeTransport' => $this->typeTransport,
            'etat' => $this->etat,
            'ordre' => $this->ordre,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nom', new Assert\NotBlank([
            'message' => 'Required field.',
        ]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'nom', 'typeTransport' ]
        ]));

        $metadata->addPropertyConstraint('etat', new Assert\NotBlank([
            'message' => 'Required field.',
        ]));

        $metadata->addPropertyConstraint('etat', new Assert\Choice([
            'choices' => [1, 2],
            'message' => 'Choose a valid genre.',
        ]));
    }
}
