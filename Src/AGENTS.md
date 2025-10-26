# Repository Guidelines

## Project Structure & Module Organization
- `public/`: Web root (entrypoint `index.php`, assets served).  
- `src/`: Application code (namespaced; classes map to folders).  
- `templates/` or `views/`: PHP/HTML templates.  
- `assets/`: CSS/JS/images for the storefront.  
- `config/`: Environment-specific settings.  
- `tests/`: Unit/integration tests.  
- `composer.json`: PHP dependencies and scripts.

## Build, Test, and Development Commands
- `composer install`: Install PHP dependencies.  
- `composer dump-autoload`: Rebuild autoloader after adding classes.  
- `composer test` or `vendor/bin/phpunit`: Run tests.  
- `composer lint` (if defined) or `vendor/bin/phpcs`: Check coding style.  
- Local run: `php -S localhost:8000 -t public` and open http://localhost:8000.

## Coding Style & Naming Conventions
- Follow PSR-12. Use 4-space indentation; UTF-8; one class per file.  
- Class names: StudlyCaps; methods/variables: camelCase; constants: UPPER_SNAKE_CASE.  
- Namespaces mirror `src/` folders (e.g., `App\\Catalog\\Product`).  
- Keep controllers thin; push business logic into services.  
- File/commit only related changes; avoid mixed concerns.

## Testing Guidelines
- Framework: PHPUnit. Store tests under `tests/` mirroring `src/` namespace.  
- Naming: `*Test.php` (e.g., `ProductServiceTest.php`).  
- Coverage: aim ≥80% for core services (cart, checkout, pricing).  
- Run focused tests: `vendor/bin/phpunit --filter ProductService`.

## Commit & Pull Request Guidelines
- Commits: imperative, scoped, and small (e.g., "Add cart total calculation").  
- Prefer Conventional Commits where helpful: `feat:`, `fix:`, `chore:`, `test:`.  
- PRs: include summary, rationale, screenshots for UI, and steps to verify.  
- Link issues (e.g., `Closes #123`) and call out breaking changes.

## Security & Configuration Tips
- Load secrets via environment (`.env`) or server config; never commit secrets.  
- Validate and sanitize all inputs; escape output in templates.  
- Set `display_errors=Off` in production; log to files/services.  
- Pin dependency versions; run `composer audit` and update regularly.

## Architecture Overview
- Typical flow: HTTP request → router/controller → service layer → repository/DB → template render.  
- Favor dependency injection and interfaces for testability.

