## installation 
Après avoir cloné le dépôt, lancez les commandes suivantes :

```bash
composer install
npm install
npm run build
```

## Utilisateurs

Il existe un utilisateur Admin :

- **Email** : admin@admin.com
- **Mot de passe** : admin

Cela permet d'accéder à un menu "gestion des utilisateurs" permettant de créer d'autres utilisateurs.

Et un utilisateur simple :

- **Email** : user@user.com
- **Mot de passe** : user

## Base de donnée

La base de donnée contient déjà des données, dont des rendez-vous et une facturation pour le mois de janvier

## Dashboard

Vue principale qui contient un graphique avec les poneys et leur nombre d'heures d'activité sur le mois choisi.

## Gestion Journalière

Vue contenant les semaines d'une année. Il est possible de générer les semaines pour une autre année.

Les rendez-vous sont assignés à une semaine choisie.

Pour assigner un rendez-vous à une semaine, il faut d'abord lui assigner les poneys disponibles ainsi que le nombre d'heures maximum qu'un poney aura le droit d'exercer sur cette semaine.

## Gestion des poneys

Il est possible de modifier le nom d'un poney, d'en ajouter un ou de le supprimer.


## Gestion Clientèle

Vue permettant d'ajouter, de modifier ou de voir un client.


## Gestion facturation

Permet de générer des factures pour un mois choisis, on peut voir le détail de la facture et/ou la téléchargée au format pdf

