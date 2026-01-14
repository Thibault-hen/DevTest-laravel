# DevTest - AI Agent Guidelines

## Project Overview

DevTest is a Laravel 12 + Inertia.js + Vue 3 quiz application using TypeScript. Developers test their knowledge through interactive quizzes with ratings, results tracking, and user authentication.

## Architecture

### Backend (Laravel 12)

- **Data Layer**: Spatie Laravel Data DTOs (`app/Data/*`) with TypeScript auto-generation (`#[TypeScript]` attribute)
- **Service Layer**: Business logic isolated in services (`app/Services/{Home,Quiz,Rating,Result}/`)
- **Controllers**: Thin controllers that delegate to services and return Inertia responses
- **Models**: Use UUIDs (`HasUuids`), observers for cache invalidation (e.g., `QuizObserver`), and scoped loading methods (e.g., `loadQuizDetails()`, `loadForPlaying()`)
- **Caching**: Redis with enum-based keys (`CacheKeys`) and tags (`CacheTags`). Observers auto-flush tagged caches on model changes

### Frontend (Vue 3 + TypeScript + Inertia)

- **Pages**: `resources/js/pages/` - Inertia pages use `defineOptions({ layout: AppLayout })` for layout assignment
- **Components**:
  - `components/ui/` - shadcn-vue components (DO NOT edit directly, managed by shadcn-vue CLI)
  - `components/quiz/`, `components/shared/` - Custom business components
- **Composables**: Extract reusable logic (e.g., `useQuizPlay.ts`, `useAppearance.ts`)
- **Routes**: Auto-generated type-safe routes via Laravel Wayfinder (`resources/js/routes/`) - import like `import { home, quiz } from '@/routes'`
- **Types**: Auto-generated from PHP Data classes at `resources/js/types/generated.d.ts` - re-run `php artisan data:typescript-transform` after changing DTOs

### Type Generation Flow

1. PHP Data classes marked with `#[TypeScript]` → `php artisan data:typescript-transform` → `resources/js/types/generated.d.ts`
2. Laravel routes → Wayfinder generates `resources/js/routes/` with full type safety
3. **Never manually edit generated files** - they're overwritten on regeneration

## Development Workflow

### Commands

```bash
# Full dev stack (queue + vite) - preferred
composer dev

# With PHP server (if needed)
composer dev2

# SSR mode
composer dev:ssr

# Run tests
composer test    # or php artisan test

# Code quality
./vendor/bin/pint              # PHP formatting (see pint.json for rules)
npm run lint                   # ESLint + fix
npm run format                 # Prettier
```

### Docker Setup

- `docker compose up --build` - Full environment (PostgreSQL, Redis)
- Access at `http://localhost:8000`

### Strict Standards

- **PHP**: Strict types required (`declare(strict_types=1);`) enforced by Pint
- **TypeScript**: Strict mode enabled, use generated types from `@/types/generated`
- **Vue**: TypeScript `<script setup lang="ts">` with explicit prop typing via `defineProps<TypeFromGeneratedTypes>()`

## Key Patterns

### Cache Management

```php
// Services use enum-based keys/tags
use App\Enums\{CacheKeys, CacheTags};

Cache::tags([CacheTags::QUIZ->value])->remember(
    CacheKeys::QUIZZES->value,
    self::CACHE_TTL,
    fn () => $this->buildQuizzesData()
);

// Observers auto-flush on model save/delete
Cache::tags([CacheTags::QUIZ->value])->flush();
```

### Data Transfer Objects

```php
// Define in app/Data/ with TypeScript attribute
#[TypeScript]
class QuizData extends Data {
    public function __construct(
        public string $id,
        public string $title,
        #[DataCollectionOf(ThemeData::class)]
        public ?DataCollection $themes = null,
    ) {}
}
```

### Controller → Service → Data Pattern

```php
// Controller delegates to service
public function index(QuizService $quizService): Response {
    $quizzesData = $quizService->getQuizzesData();
    return Inertia::render('quiz/Quizzes', $quizzesData);
}

// Service handles business logic, returns Data objects
public function getQuizzesData(): QuizzesData {
    return Cache::tags([CacheTags::QUIZ->value])->remember(...);
}
```

### Vue Component Props

```vue
<script setup lang="ts">
import { QuizData } from '@/types/generated';

// Use generated types directly
const props = defineProps<QuizData>();
</script>
```

### Type-Safe Routing

```vue
<script setup lang="ts">
import { home, quiz, quizzes } from '@/routes';

// Routes include .url and .definition properties
const breadcrumbs = [
  { title: 'Accueil', href: home().url },
  { title: 'Quizz', href: quizzes().url },
  { title: props.title, href: quiz(props.slug).url },
];
</script>
```

### Seeders Use JSON Data

Seeders read from `database/data/*.json` files (see `QuizSeeder.php`) - structured data import for themes, categories, difficulties, quizzes

## Project Structure Conventions

### Authentication

- Laravel Fortify for auth
- Two-factor authentication support (`useTwoFactorAuth` composable)
- Admin middleware checks user role (`AdminMiddleware.php`)

### Inertia Integration

- Props typed via generated PHP Data classes
- Layouts assigned via `defineOptions({ layout: AppLayout })`
- Form handling uses Wayfinder form variants (`formVariants: true` in vite.config)

### shadcn-vue Integration

- UI components in `components/ui/` managed by shadcn CLI
- Configuration in `components.json`
- Use import aliases: `@/components/ui/button`, `@/components/ui/card`
- Custom theme with dark mode support (`useAppearance` composable)

## Common Tasks

### Adding New Features

1. Create Data class in `app/Data/Feature/` with `#[TypeScript]` attribute
2. Run `php artisan data:typescript-transform` to generate TS types
3. Create service in `app/Services/Feature/` for business logic
4. Add controller in `app/Http/Controllers/Feature/` using Inertia
5. Create Vue page in `resources/js/pages/feature/`
6. Wayfinder auto-generates routes on next build

### Modifying Quizzes

- Model observers auto-clear cache on save/delete
- Load relationships carefully: `loadQuizDetails()` vs `loadForPlaying()` (different data for different contexts)

### Adding UI Components

- For shadcn components: Use shadcn-vue CLI
- For custom components: Place in appropriate directory (quiz, shared, etc.)
- Maintain TypeScript strict typing with generated types

## Testing

- Pest PHP for backend tests (`tests/Feature/`, `tests/Unit/`)
- RefreshDatabase disabled by default in `Pest.php` - enable per test if needed
- Run via `composer test` or `php artisan test`
