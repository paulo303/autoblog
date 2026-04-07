# Project Guidelines for AI Agents

This document consolidates development, architecture, and project stack guidelines, integrating business context with Laravel Boost technical rules.

## 1. Project Stack & Environment

- **Backend:** Laravel 13 (PHP 8.5)
- **Frontend:** TailwindCSS
- **Database:** PostgreSQL with `pgvector`
- **Testing:** Pest v5
- **Tooling:** Laravel Boost (MCP), Larastan v3, Pint, Rector v2, Pao v0

## 2. Architecture & Patterns

Strictly follow these architectural choices:

- **DTOs:** Use Data Transfer Objects for data transport between layers.
- **Tasks:** Decompose complex logic into reusable Tasks.
- **Processes:** Use Processes to orchestrate multiple Tasks or business flows.
- **Service Classes:** Encapsulate core business logic in Services.
- **Controllers:** Must be "thin". Delegate logic to Services/Processes.
- **Validation:** Always use `FormRequest`.
- **Tip:** `UpdateFormRequest` should extend `CreateFormRequest` to avoid duplication.

## 3. General Guidelines

- **Eloquent-First:** Always prefer Eloquent ORM over raw SQL queries.
- **Test-Driven:** Always write Pest tests for new features or fixes.
- **Type Safety:** Ensure 100% type coverage (strict types).
- **Naming:** Use descriptive names. E.g.: `isRegisteredForDiscounts` instead of `discount()`.
- **Constructor Promotion:** Use PHP 8 constructor property promotion.

## 4. Laravel Boost & MCP Tools

Use Boost tools instead of manual commands whenever possible:

- **Database:** Use `database-query` (read-only) and `database-schema` for inspection.
- **Documentation:** Always use `search-docs` before proposing changes to Laravel ecosystem packages.
- **Artisan:** Run commands via CLI (e.g.: `php artisan route:list`).
- **Tinker:** Use for quick debugging, but prefer tests with factories for persistence.
- **URLs:** Use `get-absolute-url` to resolve project URLs correctly.

## 5. Code Quality & Formatting

- **Pint:** Before finalizing, run `vendor/bin/pint --dirty --format agent`.
- **PHPDoc:** Prefer PHPDoc blocks over inline comments.
- **Type Hints:** Use explicit type declarations for all parameters and return types.
