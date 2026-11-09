# Web-Based Barangay Incident and Mediation Case Management System
Group members:
Giann Joelle A. Lim
Brent Moises C Sto.tomas

## Description
A Web based System where residents file barangay complaints online and barangay officials review them,schedule Katarungang Pambarangay mediation hearings, and track each case until it is settled, escalated, or dismissed.

## User roles
| Resident | Register log in, edit profile, file complaints, view only their own complaints and hearing schedules, see a hearing calendar, receive notifications.
##
| Barangay Official | Log in, view all complaints edit or delete complaints, update case status, add / edit / delete hearings, record summons delivery (served by, date, status), print summons / notice of hearing / settlement, see the hearing calendar, view Reports (graphs), view the SMS log |

## Core feature
Complaint filing and mediation case tracking. A resident files a complaint (validated on the server and saved with their user id and an auto blotter number such as`BLT-2026-0001`). The official reviews it, edits it, changes its status
and schedules hearings. Every change creates a notification for the resident.

## Other features
- Reports page
- Printable summons, notice of hearing and settlement forms
- Hearing calendar for both roles
- Service record per hearing (summons status, served by, date served)
- Warning when the respondent already has other cases

## Demo accounts (created by the seeder, password for all: `password`)
| Role | Name | Email |
| Barangay Official | Officials | official@gmail.com |
| Resident | Residents | resident@gmail.com |

## Setup (from a fresh clone)
git clone <your-repo-url> bims
cd bims
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run dev          
php artisan serve    
