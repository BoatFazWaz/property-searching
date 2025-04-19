# FazWaz Property Search Application

A full-stack application for property searching, built with Laravel and Vue.js.

## Features

- Property listing and search functionality
- Property details view
- Responsive design
- Modern UI with Tailwind CSS
- RESTful API backend

## Requirements

- PHP >= 8.1
- Node.js >= 16
- MySQL >= 5.7
- Composer
- NPM/Yarn
- Docker (for Laravel Sail)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd property-searching
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fazwaz
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run build
```

## Development

### Using Laravel Sail (Recommended)

Laravel Sail provides a Docker-based development environment for Laravel without requiring prior Docker experience.

1. Start the development environment:
```bash
./vendor/bin/sail up -d
```

2. Run migrations and seed the database:
```bash
./vendor/bin/sail artisan migrate --seed
```

3. Install JavaScript dependencies and build assets:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

4. Access the application at `http://localhost`

To stop Sail:
```bash
./vendor/bin/sail down
```

#### Sail Shortcuts

You can also add a shell alias for Sail to make commands shorter:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Then you can simply use:
```bash
sail up -d
sail artisan migrate
sail npm run dev
```

### Traditional Setup

To start the development server:

```bash
php artisan serve
```

For frontend development with hot reloading:

```bash
npm run dev
```

## Property Model

The Property model includes the following required fields:

- `title` - Property title/name
- `description` - Property description
- `for_sale` - Boolean indicating if property is for sale
- `for_rent` - Boolean indicating if property is for rent
- `sold` - Boolean indicating if property is sold
- `price` - Property price (decimal)
- `currency` - Currency code (e.g., THB)
- `currency_symbol` - Currency symbol (e.g., ฿)
- `property_type` - Type of property (e.g., Condo, House, Villa)
- `bedrooms` - Number of bedrooms
- `bathrooms` - Number of bathrooms
- `area` - Property area size
- `area_type` - Area unit (e.g., sqm)
- `country` - Country where property is located
- `province` - Province/City where property is located
- `street` - Street address

Optional fields include:
- `photo_thumb` - Thumbnail image URL
- `photo_search` - Search result image URL
- `photo_full` - Full-size image URL

## Testing

Run PHP tests:
```bash
php artisan test
```

When writing tests for the Property model, ensure all required fields are included in test data. The tests use DatabaseTransactions to prevent test data from persisting between test runs.

Run a specific test file:
```bash
php artisan test tests/Unit/PropertyModelTest.php
```

### Testing with Sail

To run tests using Laravel Sail:
```bash
./vendor/bin/sail artisan test
```

Run a specific test:
```bash
./vendor/bin/sail artisan test tests/Unit/PropertyModelTest.php
```

Run JavaScript tests:
```bash
npm run test
```

## Deployment

1. Build production assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan optimize
```

3. Deploy to your server

## Troubleshooting

If you encounter database connection issues during testing, ensure:
1. Your database credentials in `.env` are correct
2. The database user has proper permissions
3. The database exists and is accessible

When using Sail, ensure that:
1. Docker is running on your system
2. No other services are using ports 80, 3306, or other ports required by Sail

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License.