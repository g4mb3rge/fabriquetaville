# Fabrique ta Ville

> **Tes idées font la ville.**

Plateforme de participation citoyenne pour les habitants de **Rennes** (projet ParticipaCity).
Les habitants peuvent signaler un problème, proposer une idée, soutenir les besoins qu'ils partagent,
suivre ce que deviennent leurs contributions et participer aux consultations quand un besoin devient un projet.

Projet de cours — EFREI Paris Panthéon-Assas, Bachelor Cybersécurité & Ethical Hacking.

---

## Stack technique

| Couche     | Techno                                              |
|------------|-----------------------------------------------------|
| Backend    | Symfony (LTS), API REST JSON, Doctrine ORM          |
| Auth       | JWT (rôles `ROLE_USER` habitant / `ROLE_AGENT` Ville) |
| Frontend   | React + Vite, mobile first                          |
| Base de données | MySQL 8.4 (via Docker)                         |
| Carte      | Leaflet / react-leaflet                             |

## Structure du dépôt

```
fabriquetaville/
├── backend/            # API Symfony
├── frontend/           # Application React (Vite)
├── docs/               # Spécifications fonctionnelles (issues du brand book)
├── docker-compose.yml  # Base MySQL
└── README.md
```

---

## Installation (macOS)

### 1. Prérequis

```bash
brew install php composer node
brew install symfony-cli/tap/symfony-cli
symfony check:requirements
```

Installer aussi **Docker Desktop**.

### 2. Cloner le dépôt

```bash
git clone https://github.com/g4mb3rge/fabriquetaville.git
cd fabriquetaville
```

### 3. Base de données

```bash
docker compose up -d
```

### 4. Backend

> Première installation seulement (création du squelette, à faire **une seule fois** par l'équipe) :
> ```bash
> symfony new backend --version=lts --no-git
> cd backend
> composer require symfony/orm-pack symfony/serializer-pack symfony/validator symfony/security-bundle nelmio/cors-bundle
> composer require --dev symfony/maker-bundle
> ```

Ensuite, pour chaque membre de l'équipe :

```bash
cd backend
composer install
```

Créer `backend/.env.local` (non versionné) :

```
DATABASE_URL="mysql://app:app@127.0.0.1:3306/fabriquetaville?serverVersion=8.4&charset=utf8mb4"
```

Vérifier la connexion puis lancer le serveur :

```bash
php bin/console dbal:run-sql "SELECT 1"
symfony server:start -d        # https://127.0.0.1:8000
```

### 5. Frontend

> Première installation seulement :
> ```bash
> npm create vite@latest frontend -- --template react
> ```

```bash
cd frontend
npm install
npm run dev                    # http://localhost:5173
```

---

## Feuille de route

- [ ] 1. Mise en place de l'environnement
- [ ] 2. Modèle de données (entités Doctrine + migrations)
- [ ] 3. Authentification (inscription, connexion, rôles)
- [ ] 4. API contributions (création, liste, filtres, détail)
- [ ] 5. Soutiens « Je soutiens » + suivi des statuts
- [ ] 6. Design system front (couleurs, DM Sans, boutons, badges de statut)
- [ ] 7. Accueil, navigation basse, formulaire en 5 étapes
- [ ] 8. Carte participative
- [ ] 9. Espace collectivité
- [ ] 10. Projets, consultations et votes
- [ ] 11. Datavisualisations

Le détail fonctionnel est dans [`docs/specifications.md`](docs/specifications.md).

## Conventions Git

- Branche principale : `main` (toujours fonctionnelle)
- Une branche par fonctionnalité : `feature/auth`, `feature/carte`…
- Fusion via Pull Request, relue par l'autre membre de l'équipe
