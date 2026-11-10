<?php

namespace App\Enum;

/**
 * Statuts des projets (brand book, section 8.6).
 *
 * Projet retenu → Consultation ouverte → Décision prise → En réalisation → Réalisé
 */
enum StatutProjet: string
{
    case PROJET_RETENU = 'projet_retenu';
    case CONSULTATION_OUVERTE = 'consultation_ouverte';
    case DECISION_PRISE = 'decision_prise';
    case EN_REALISATION = 'en_realisation';
    case REALISE = 'realise';

    public function libelle(): string
    {
        return match ($this) {
            self::PROJET_RETENU => 'Projet retenu',
            self::CONSULTATION_OUVERTE => 'Consultation ouverte',
            self::DECISION_PRISE => 'Décision prise',
            self::EN_REALISATION => 'En réalisation',
            self::REALISE => 'Réalisé',
        };
    }

    public function suivant(): ?self
    {
        return match ($this) {
            self::PROJET_RETENU => self::CONSULTATION_OUVERTE,
            self::CONSULTATION_OUVERTE => self::DECISION_PRISE,
            self::DECISION_PRISE => self::EN_REALISATION,
            self::EN_REALISATION => self::REALISE,
            self::REALISE => null,
        };
    }

    public function peutPasserA(self $nouveau): bool
    {
        return $this->suivant() === $nouveau;
    }
}
