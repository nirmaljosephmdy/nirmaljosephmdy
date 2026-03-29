# ⚖️ euVerify: European Product Compliance Platform

> **The Digital Notary** for B2B compliance. This platform transforms complex regulatory requirements into an experience of absolute certainty, leveraging high-end editorial clarity and architectural depth.

---

> [!CAUTION]
> **SUBMISSION CRITICALS**
> - **Late Submission**: Automatic Disqualification.
> - **No README**: Automatic Disqualification.
> - **Credentials Committed**: Automatic Disqualification (ensure `.env` is ignored).
> - **Project Won't Run**: Automatic Disqualification.

---

## 📑 Table of Contents
- [Setup Steps](#-setup-steps)
- [Environment Variables](#-environment-variables)
- [Seed Credentials](#-seed-credentials)
- [Frontend Architecture](#-frontend-architecture)
- [Stripe Integration](#-stripe-integration)
- [Technical Decisions](#-technical-decisions)
- [Incomplete Items](#-incomplete-items)
- [Time Log](#-time-log)

---

## 🛠 Setup Steps
Follow these steps to initialize the "Digital Notary" environment from a fresh clone.

1. **Repository Initialization**
   ```bash
   git clone <repository-url>
   cd euVerify
   ```

2. **Dependency Management**
   ```bash
   composer install
   npm install
   ```

3. **System Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Persistence Layer**
   Configure your database in `.env` then execute:
   ```bash
   php artisan migrate --seed
   ```

5. **Execution**
   ```bash
   npm run setup  # (Custom script for full initialization)
   # Or manually:
   npm run dev
   php artisan serve
   ```

---

## 🔑 Environment Variables
Every key required to maintain the platform's integrity.

| Category | Key | Example / Default |
| :--- | :--- | :--- |
| **App** | `APP_NAME` | `euVerify` |
| **Database** | `DB_CONNECTION` | `mysql` |
| **Stripe** | `STRIPE_KEY` | `pk_test_...` |
| **Stripe** | `STRIPE_SECRET` | `sk_test_...` |
| **Storage** | `FILESYSTEM_DISK` | `local` |
| **Mail** | `MAIL_MAILER` | `log` (Dev) |

---

## 🔐 Seed Credentials
Standard administrative and manufacturer accounts for the `euverify.test` local environment.

### Admin Access
- **Email**: `admin@euverify.com`
- **Password**: `password`

### Manufacturer Access
- **Email**: `manufacturer@test.com`
- **Password**: `password`

---

## 🎨 Frontend Architecture
**Stack**: Blade Templates + Tailwind CSS 4

### Why Blade?
In line with our "Digital Notary" philosophy, we chose **Blade** for its **Server-Driven Authority**. 
- **Clarity over Complexity**: Avoids the "fragility" of heavy JS SPAs for data-dense compliance workflows.
- **Editorial Speed**: Native Laravel integration allows for rapid structural changes without client-side state overhead.
- **Performance**: Zero-latency initial renders for critical compliance dashboards.

---

## 💳 Stripe Integration
The platform operates exclusively in **Stripe Test Mode** for the current release cycle.

- **Status**: Active (Test Mode)
- **Feature Gating**: Managed via `ManufacturerMiddleware` based on active Stripe subscription status.
- **Keys**: Use the `pk_test` and `sk_test` keys provided in the `.env` configuration.

---

## 🧠 Technical Decisions
- **Laravel 12**: Future-proofing the architecture with the latest PHP framework features.
- **Moderation Service Pattern**: Centralized logic in `AdminModerationService` to ensure a single source of truth for compliance status transitions.
- **Identity Barrier**: Strict enforcement of company registration before a manufacturer can register products.
- **No-Line Layout**: Following the `DESIGN.md` guidelines, we use background shifts (`surface` vs `surface_container_low`) instead of thick borders for a premium feel.

---

## 🚧 Incomplete Items
- **Live Mail Integration**: Emails are currently captured in the `laravel.log` file.
- **Webhook Production Readiness**: Live production webhook secrets are placeholders.
- **Asset CDN**: Assets are currently served locally via Vite; a CDN is recommended for production scale.

---

## ⏱ Time Log
| Module | Focus Area | Hours |
| :--- | :--- | :--- |
| **Core** | System Design & Setup | 4 |
| **Auth** | RBAC & Role Management | 3 |
| **Admin** | Dashboard & Moderation Flow | 15 |
| **Onboarding** | Manufacturer Identity Setup | 6 |
| **Payments** | Stripe Subscription Engine | 8 |
| **UI/UX** | Aesthetic Polish & Tailwind 4 | 5 |
| **Total** | | **41** |

---
> [!IMPORTANT]
> This documentation is part of the final submission. Ensure any changes to the `.env` are mirrored in `.env.example` before pushing.
