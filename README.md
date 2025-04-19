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

To start the development server:

```bash
php artisan serve
```

For frontend development with hot reloading:

```bash
npm run dev
```

## Testing

Run PHP tests:
```bash
php artisan test
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

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License.