# YAMCI — Gestion de Stock & Point de Vente

Application web de gestion commerciale complète, construite sur le framework **CodeIgniter** (PHP 7.4 / 8.x).
Basée sur [Stock Manager Advance v3.5.5](https://tecdiary.com), fortement personnalisée.

## Fonctionnalités

- **Ventes & Achats** — création, suivi et retours
- **Caisse (POS)** — interface point de vente avec impression ESC/POS
- **Gestion des stocks** — produits, transferts, fournisseurs, clients
- **Devis & Promotions** — génération de devis et gestion des promos
- **Paiements** — intégration Stripe, passerelles multiples
- **Factures & PDF** — génération via mPDF / DomPDF, QR code, codes-barres
- **Export Excel** — via PhpSpreadsheet
- **Facturation électronique** — support norme ZATCA (Arabie Saoudite)
- **Rapports & Tableaux de bord** — KPIs, graphiques mensuels ventes/achats
- **Notifications & Agenda**
- **Authentification** — OAuth (Google, HybridAuth), Ion Auth
- **Support multilingue** — dont l'arabe (ar-php)

## Stack technique

| Couche       | Technologie                          |
|-------------|--------------------------------------|
| Framework   | CodeIgniter 3                        |
| Langage     | PHP 7.4 / 8.x                        |
| Base de données | MySQL                            |
| Frontend    | Bootstrap 5, Sneat Theme             |
| PDF         | mPDF, DomPDF                         |
| Paiement    | Stripe                               |
| Email       | PHPMailer                            |
| Impression  | ESC/POS (mike42/escpos-php)          |

## Prérequis

- PHP >= 7.4
- MySQL >= 5.7
- Composer

## Installation

```bash
git clone https://github.com/Yamoon224/yamci.git
cd yamci
composer install
# Configurer database.php
# Importer le schéma SQL via install/# YAMCI-ABCR-GESTION
