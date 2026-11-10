<?php

namespace App\Entity;

use App\Repository\SoutienRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * « Je soutiens » : un habitant appuie une idée.
 * La contrainte unique empêche de soutenir deux fois la même idée.
 */
#[ORM\Entity(repositoryClass: SoutienRepository::class)]
#[ORM\UniqueConstraint(name: 'soutien_unique', columns: ['user_id', 'contribution_id'])]
class Soutien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'soutiens')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Contribution $contribution;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(User $user, Contribution $contribution)
    {
        if (!$contribution->peutEtreSoutenue()) {
            throw new \DomainException('Seules les idées peuvent être soutenues.');
        }

        $this->user = $user;
        $this->contribution = $contribution;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getContribution(): Contribution
    {
        return $this->contribution;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
