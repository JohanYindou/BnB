# BnB platform

## Description

Ce projet est une plateforme de réservation de chambres dans un BnB.
Ce projet est réalisé avec mes étudiants dans le cadre d'un cours de développement web.

Les technologies utilisées sont :

- Symfony 7
- MySQL

## Installation du projet

Pour installer BnB, vous avez besoin de Composer et Symfony.
Après avoir cloné le dépôt sur votre machine locale, ouvrez un terminal et tapez les lignes de code suivantes :

```bash
composer install
```

Cela permet d'installer les dépendances de l'application.

Après avoir installé les dépendances, il est nécessaire d'initialiser la base de données et le mailer de l'application.
Vous pouvez tout d'abord crée un fichier .env.local qui contient les informations de connexion a la base de données et le mailer de l'application.
Modifiez le fichier .env en commentant la variable DATABASE_URL.
Si vous souhaitez changer MySQL en une autre base de données, libre à vous.

Vous pouvez créer la base de données en utilisant la commande suivante :

```bash
symfony console doctrine:database:create
```

Si il manque le fichier migration créer le manuellement à la racine du projet.
Ensuite, pour créer les migrations :

```bash
symfony console make:migration
```

Pour appliquer les migrations à la base de données :

```bash
symfony console doctrine:migrations:migrate
```

Enfin, il faut charger les fixtures générées par Faker dans la base de données :

```bash
symfony console doctrine:fixtures:load
```

## Entities

### User

This entity represents a user of the platform. The user can be a traveler or a host. They are defined by the `role` property.

| Property   | Type      | Description          | Relation |
| ---------- | --------- | -------------------- | -------- |
| email      | string    | 180 NOT NULL, UNIQUE |          |
| password   | string    | 255 NOT NULL         |          |
| firstname  | string    | 50                   |          |
| lastname   | string    | 50                   |          |
| role       | string    | 50 NOT NULL          |          |
| image      | string    | 255                  |          |
| address    | string    | 255                  |          |
| city       | string    | 50                   |          |
| country    | string    | 50                   |          |
| created_at | datetime  | NOT NULL             |          |
| rooms      | OneToMany |                      | Room     |
| bookings   | OneToMany |                      | Booking  |
| reviews    | OneToMany |                      | Review   |

---

### Room

This entity represents a room for rent.

| Property    | Type       | Description          | Relation  |
| ----------- | ---------- | -------------------- | --------- |
| title       | string     | 50 NOT NULL          |           |
| description | text       | NOT NULL             |           |
| price       | integer    | NOT NULL             |           |
| address     | string     | 255                  |           |
| city        | string     | 50                   |           |
| country     | string     | 50                   |           |
| created_at  | datetime   | NOT NULL             |           |
| host        | ManyToOne  | NOT NULL, OrphanTrue | User      |
| bookings    | OneToMany  |                      | Booking   |
| reviews     | OneToMany  |                      | Review    |
| equipements  | ManyToMany |                      | Equipement |

---

### Review

This entity represents a review made by a traveler to a booking for a room.

| Property   | Type      | Description          | Relation |
| ---------- | --------- | -------------------- | -------- |
| title      | string    | 50 NOT NULL          |          |
| comment    | text      | NOT NULL             |          |
| rating     | integer   | NOT NULL             |          |
| created_at | datetime  | NOT NULL             |          |
| traveler   | ManyToOne | NOT NULL, OrphanTrue | User     |
| rooms      | ManyToOne | NOT NULL, OrphanTrue | Room     |
| booking    | OneToOne  | NOT NULL, OrphanTrue | Booking  |

---

### Booking

This entity represents a booking made by a traveler to a room.

| Property   | Type      | Description          | Relation |
| ---------- | --------- | -------------------- | -------- |
| number     | string    | 50 NOT NULL          |          |
| check_in   | datetime  | NOT NULL             |          |
| check_out  | datetime  | NOT NULL             |          |
| occupants  | integer   | NOT NULL             |          |
| created_at | datetime  | NOT NULL             |          |
| traveler   | ManyToOne | NOT NULL, OrphanTrue | User     |
| room       | ManyToOne | NULL, OrphanTrue     | Room     |
| review     | OneToOne  | NULL, OrphanTrue     | Review   |

---

### Equipement

This entity represents the equipements for a room.

| Property | Type       | Description | Relation |
| -------- | ---------- | ----------- | -------- |
| name     | string     | 50 NOT NULL |          |
| rooms    | ManyToMany |             | Room     |

---

## Pages architecture

-- paris, kyoto, las vegas, sydney, hong kong
    -- all rooms
        -- room
            -- booking
                -- payment
-- login
-- register
-- account
    -- my rooms
        -- new room
        -- edit room
    -- my bookings
        -- booking
    -- my reviews
        -- review
