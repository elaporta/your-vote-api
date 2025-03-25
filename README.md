# Your Vote API 🗳️

A modern voting system API built with Laravel, providing secure and efficient vote management.

## 🚀 Quick Start

### Prerequisites
- PHP 8.4 or higher
- MySQL 8.0 or higher
- Composer

### Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer update
   composer dump-autoload
   ```
3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan jwt:secret
   ```
4. Configure your `.env` file with your database credentials and other settings
5. Run this script to optimize and refresh cache variables
   ```bash
   composer renv
   ```
### Database Setup

You have two options:

#### Option 1: Fresh Setup
1. Create a new MySQL database
2. Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed --class=AdminSeeder
   php artisan db:seed --class=CandidatesSeeder
   php artisan db:seed --class=VotersSeeder
   ```

#### Option 2: Import Database Dump
Import the provided database dump:
```bash
mysql -u your_username -p your_database < database/dump/your_vote_dump.sql
```

### Running the Application
```bash
php artisan serve
```
Or configure your preferred virtual host.

## 🔑 Default Admin Credentials
- **Email:** admin@admin.com
- **Password:** Admin123.

## 📚 API Documentation

### Authentication Routes
- **POST** `/auth/login` - Authenticate an admin user.
- **GET** `/auth/logout` - Log out the authenticated user.
- **GET** `/auth/refresh` - Refresh authentication token.
- **GET** `/auth/profile` - Get admin profile details.
- **PUT** `/auth/password` - Update admin password.

### Voter Routes (Admin Only)
- **GET** `/voter` - Get all voters.
- **GET** `/voter/{id}` - Get voter details by ID.
- **POST** `/voter` - Create a new voter.
- **PUT** `/voter` - Update voter details.
- **DELETE** `/voter/{id}` - Delete a voter.

### Candidate Routes
- **GET** `/candidate` - Get all candidates (Public).
- **GET** `/candidate/{id}` - Get candidate details by ID (Admin Only).
- **POST** `/candidate` - Create a new candidate (Admin Only).
- **PUT** `/candidate` - Update candidate details (Admin Only).
- **DELETE** `/candidate/{id}` - Delete a candidate (Admin Only).
- **GET** `/candidate/by/votes` - Get candidates sorted by votes (Admin Only).

### Vote Routes
- **POST** `/vote` - Cast a vote (Public).
- **GET** `/vote` - Get all votes (Admin Only).
- **GET** `/vote/{id}` - Get vote details by ID (Admin Only).

## Postman Collection 📨 
your-vote.postman_collection