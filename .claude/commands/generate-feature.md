# Generate Complete Feature

Scaffold a complete feature from backend to frontend with tests and documentation.

## Command: /generate-feature [feature-name]

## Generation Process

### Step 1: Feature Planning
Analyze the feature requirements and generate:
- Database migrations
- Models with relationships
- API endpoints
- Livewire components
- Tests structure
- Documentation outline

### Step 2: Backend Generation

#### Database Layer
```bash
# Generate migration
php artisan make:migration create_[feature]_table

# Generate model with factory
php artisan make:model [Feature] -mf

# Generate seeder
php artisan make:seeder [Feature]Seeder
```

#### Business Logic
```bash
# Generate service class
php artisan make:class Services/[Feature]Service

# Generate repository
php artisan make:class Repositories/[Feature]Repository

# Generate form request
php artisan make:request [Feature]Request
```

### Step 3: Frontend Generation

#### Livewire Components
```bash
# Generate main component
php artisan make:livewire [Feature]Manager

# Generate sub-components
php artisan make:livewire [Feature]List
php artisan make:livewire [Feature]Form
php artisan make:livewire [Feature]Detail
```

#### Views and Assets
- Create Blade templates
- Add Tailwind components
- Setup JavaScript interactions

### Step 4: Testing Structure

```bash
# Unit tests
php artisan make:test [Feature]ServiceTest --unit
php artisan make:test [Feature]RepositoryTest --unit

# Feature tests
php artisan make:test [Feature]ApiTest
php artisan make:test [Feature]LivewireTest

# Browser tests
php artisan dusk:make [Feature]Test
```

### Step 5: Documentation

Generate:
- API documentation
- Component documentation
- Usage examples
- Configuration guide

## Feature Templates

### CRUD Feature
```yaml
components:
  - Migration with standard fields
  - Model with relationships
  - Resource controller
  - Livewire CRUD components
  - Index/Create/Edit/Show views
  - Full test suite
```

### API Feature
```yaml
components:
  - API controller
  - API resource
  - Route definitions
  - Postman collection
  - API tests
  - API documentation
```

### Reporting Feature
```yaml
components:
  - Data aggregation service
  - Export functionality (PDF/Excel)
  - Chart components
  - Scheduled jobs
  - Report tests
```

## Example Usage

```bash
# Generate user management feature
/generate-feature user-management

# Generate analytics dashboard
/generate-feature analytics-dashboard

# Generate notification system
/generate-feature notifications

# Generate export feature
/generate-feature data-export
```

## Post-Generation Checklist

- [ ] Run migrations
- [ ] Update route files
- [ ] Register service providers
- [ ] Update navigation menu
- [ ] Add feature flag
- [ ] Update documentation
- [ ] Run tests
- [ ] Add to deployment