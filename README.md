# Bartolomeus Bima Portfolio

A custom PHP portfolio website for presenting selected work, project case studies, blog writing, and printable CV/resume pages in a lightweight server-rendered experience.

This repository is intentionally framework-light. It uses a simple PHP router, modular page templates, and small vanilla JavaScript modules for UI behavior such as theme switching, language toggling, and interaction effects. Most portfolio content is driven by structured database records for companies, projects, skills, timelines, and blog articles.

## What This Showcases

- Clean server-rendered PHP architecture without a heavy framework
- Bilingual interface with English and Indonesian content switching
- Structured portfolio browsing by company and by project
- Detailed project case studies with responsibilities, flow, technical notes, and outcomes
- Blog listing and article detail pages
- Printable CV and resume preview pages
- Open Graph and canonical metadata support
- Graceful fallback behavior when database content is unavailable

## Project Goals

This project was built to do more than act as a personal landing page. The goal was to create a portfolio experience that:

- presents technical work in a structured and story-driven way
- makes project context easy to scan for recruiters and collaborators
- stays lightweight and maintainable without depending on a large framework
- supports bilingual presentation for broader accessibility
- allows portfolio content to evolve through database-backed records instead of hardcoded pages only

## Quick Start

### Requirements

- PHP 8.x recommended
- A MySQL-compatible database if you want dynamic content populated

### Run Locally

1. Copy `.env.example` to `.env`
2. Fill in valid database credentials
3. Start the built-in PHP server from the project root

```bash
php -S localhost:8000 router.php
```

4. Open:

```text
http://localhost:8000
```

If the database is empty or unavailable, the app still renders the static sections, while dynamic work/blog sections may appear empty.

---

## Project Structure

```text
portfolio/
|-- application/
|   |-- configs/
|   |-- controllers/
|   `-- models/
|-- assets/
|   |-- css/
|   |-- fonts/
|   |-- images/
|   `-- js/
|-- pages/
|-- templates/
|-- index.php
|-- router.php
`-- README.md
```

### Main Layers

- `index.php`
  Main router entry. Resolves static routes, blog slug routes, work company routes, project routes, and legacy aliases.

- `router.php`
  Development router for the built-in PHP server.

- `application/models/View.php`
  Primary read model for portfolio data. Handles database access for work companies, projects, skills, timelines, and blog content.

- `application/controllers/`
  JSON endpoints for blog and work-related data.

- `pages/`
  Server-rendered page templates for public routes such as home, work, blog, about, contact, CV, and resume.

- `templates/`
  Shared partials such as navbar, Open Graph metadata, blog content sections, and project/company exploration blocks.

- `assets/`
  Page-specific CSS, small JavaScript modules, fonts, icons, and portfolio imagery.

---

## Site Sections

- `/`
  Home landing page

- `/work`
  Work index organized by company

- `/work/projects`
  Work index organized by project

- `/work/{company-slug}`
  Company detail page with summary, featured projects, and timeline

- `/work/{company-slug}/{project-slug}`
  Project case study page

- `/blog`
  Blog archive

- `/blog/{slug}`
  Blog article detail

- `/about`
  Personal profile page

- `/contact`
  Contact and outbound links

- `/preview-cv`
  Dynamic CV preview

- `/preview-resume`
  Resume preview

---

## Tech Stack

- Backend rendering: PHP
- Routing: custom PHP router
- Data access: PDO-based custom query layer
- Database: MySQL-compatible configuration via environment variables
- Frontend behavior: vanilla JavaScript
- Styling: handcrafted CSS split by page/module
- Assets: local fonts, images, SVG icons

## Key Engineering Decisions

- Server-rendered PHP instead of a frontend-heavy stack
  This keeps the project lightweight, fast to load, and easy to deploy while still supporting dynamic content.

- Framework-light architecture
  The codebase is intentionally simple so the routing, page composition, and data flow are easy to follow.

- Database-driven content model
  Work history, projects, skills, blog content, and timeline entries are structured so the portfolio can grow without rewriting page templates.

- Modular page and template separation
  Shared UI pieces such as metadata, navigation, and exploration sections are split into reusable partials to keep rendering logic organized.

- Graceful fallback behavior
  Static sections still render even if database content is unavailable, which helps the site degrade more safely in partial-failure scenarios.

---

## Data Model Overview

The portfolio is organized around several core entities:

- `ms_work_company`
  Company or engagement-level portfolio entries

- `ms_work_project`
  Project records linked to a work company

- `ms_work_company_timeline`
  Timeline items and milestones for a company page

- `ms_skill`
  Technology and skill references

- `ms_work_project_skill`
  Project-to-skill relationship table

- `ms_blog_head`
  Blog article metadata

- `ms_blog_detail`
  Blog article content sections

Some project fields are stored as JSON strings in the database and decoded by the application for:

- responsibilities
- problem and solution sections
- application flow
- technical notes

---

## Environment Variables

The app loads variables from `.env` using `application/configs/env_loader.php`.

Typical variables used by the project:

```env
APP_ENV=local
DB_HOST=127.0.0.1
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password
DB_PORT=3306
DB_DRIVER=mysql
DB_CHARSET=utf8mb4
```

Notes:

- If database credentials are missing or invalid, the app does not crash immediately.
- Dynamic sections that depend on database content may render as empty states instead.
- This repository does not include production credentials.

---

## API Endpoints

The project also exposes lightweight JSON endpoints:

- `/api/blog`
- `/api/work`
- `/api/work/company`
- `/api/work/project`

These endpoints are used to expose structured portfolio data and can also help with future frontend enhancements or content integrations.

---

## UI Behavior

The global UI layer includes:

- language toggle between English and Indonesian
- theme toggle between dark and light modes
- stored user preference via `localStorage`
- reveal and animation helpers for page transitions
- carousel and accordion behavior on work/project pages

---

## Notes About Content

This portfolio mixes:

- static authored content in PHP page files
- dynamic content loaded from database tables
- print-oriented variants for CV and resume

Because of that, the project is best understood as a hybrid portfolio CMS-style site rather than a purely static website.

---

## Repository Status

This repository currently does not include:

- Composer-based dependency management
- automated test setup
- database migrations or schema files
- deployment automation scripts

Those are reasonable future improvements if the project evolves into a more reusable platform.

## Why This Repo Exists

This repo is primarily meant to showcase:

- project structure and code organization
- PHP routing and templating approach
- portfolio information architecture
- practical frontend polish without a framework
- database-backed content modeling for personal branding use cases

## What I'd Improve Next

If this project were extended beyond portfolio presentation, the next improvements would likely be:

- database schema or migration files for easier onboarding
- automated tests for routing, rendering, and data access behavior
- deployment notes or infrastructure automation
- an admin/content workflow to reduce direct database editing
- stricter environment-based configuration for local vs production behavior

---

## Contact

Created for Bartolomeus Bima Santoso's personal portfolio.

Portfolio: `bartolomeusbima.com`  
LinkedIn: `linkedin.com/in/bartolomeus-bima-santoso`

This project is intended for portfolio presentation and personal branding purposes.
