<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * « Je vote » : un habitant choisit une option dans une consultation.
 * La contrainte unique garantit un seul vote par personne et par consultation.
 */
#[ORM\Entity(repositoryClass: VoteRepository::class)]
#[ORM\UniqueConstraint(name: 'vote_unique', columns: ['user_id', 'consultation_id'])]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Consultation $consultation;

    // `option` est un mot réservé MySQL : on nomme la colonne explicitement
    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(name: 'option_vote_id', nullable: false, onDelete: 'CASCADE')]
    private OptionVote $option;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(User $user, OptionVote $option)
    {
        $consultation = $option->getConsultation();

        if (!$consultation->estOuverte()) {
            throw new \DomainException('Cette consultation n\'est pas ouverte au vote.');
        }

        $this->user = $user;
        $this->option = $option;
        $this->consultation = $consultation;
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

    public function getConsultation(): Consultation
    {
        return $this->consultation;
    }

    public function getOption(): OptionVote
    {
        return $this->option;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
