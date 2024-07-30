# ESTIMATION MODULE POUR L'API DVF DE SOGEFI

## DVF API

L'API [SOGEFI](https://geoservices.sogefi-sig.com/) pour [la Demande de Valeur Foncière ou DVF](https://geoservices.sogefi-sig.com/documentation.php?doc=api_dvf_v2&api=dvf) permet de récuperer les valeurs des secteurs / parcelles foncières afin de les proposer aux clients.<br />
Le projet ESTIMATION MODULE permettra de consommer cette API en mettant en place un package Laravel.

## LE MODULE

- Récuperation d'une adresse et transformation en GeoJSON avec la rayon du cercle
- Récuperation des données d'une disposition pour une adresse donnée
- Récuperation des données d'une passerelle dans une disposition

## Installation

```bash
composer require koders/estimation-module
```

## Pré-requis

- php ^8.0
- Laravel ^9.0
