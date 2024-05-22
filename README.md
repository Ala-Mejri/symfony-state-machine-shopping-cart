# Coding Challenge: State machine shopping cart

## The Problem
[Problem instructions](problem-instructions.pdf)


## My Solution
The solution was designed with the following concepts in mind: Clean architecture, DDD, SOLID principles, CQRS and ADR.

Doctrine implementation and mapping are defined in the Infrastructure Layer, which makes it easy to switch to another ORM in the future by simply providing new implementations for entity repositories.

## I. Environment
- PHP: 8.2
- Symfony: 7
- PHPUnit: 9
- Database: SQLite
- TypeScript


## II. Setup
### 1. Dependencies installation
- composer install

### 2. Assets setup
- npm install
- npm run dev

### 3. Database setup
- symfony console doctrine:database:create
- symfony console make:migration
- symfony console doctrine:migrations:migrate
- symfony console doctrine:fixtures:load

### 4. Starting the server
- symfony server:start
- Visit http://localhost:8000

### 5. Delete expired carts
- symfony console app:remove-expired-carts


## III. Testing
### 1. Database setup
- symfony console doctrine:database:create -e test
- symfony console doctrine:schema:create -e test
- symfony console doctrine:fixtures:load -e test

### 2. Running the tests
- php bin/phpunit


## IV. Login credentials
### Admin credentials
- Email: admin@random-email.de 
- Password: 123456

### User credentials
- Email: user@random-email.de
- Password: 123456


### V. Possible Future Improvements
- Use DTOs for requests/responses.
- Add more unit, integration, and functional tests to cover the totality of the code.
- Currently, all our models are defined as entities; however, we can introduce some DDD concepts like aggregate roots and value objects as well.
- We can also move some logic inside our entities to transform them from simple anemic entities to rich domain models.

### VI. Feedback
I will be looking forward to your feedback!
