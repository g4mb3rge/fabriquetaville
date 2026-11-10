<?php

namespace App\Entity;

use App\Repository\ReponseOfficielleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Réponse officielle de la Ville, visible par tous les habitants.
 */
#[ORM\Entity(repositoryClass: ReponseOfficielleRepository::class)]
class ReponseOfficielle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Contribution $contribution;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $agent;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La réponse ne peut pas être vide.')]
    #[Assert\Length(max: 3000)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(Contribution $contribution, User $agent)
    {
        $this->contribution = $contribution;
        $this->agent = $agent;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContribution(): Contribution
    {
        return $this->contribution;
    }

    public function getAgent(): User
    {
        return $this->agent;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
