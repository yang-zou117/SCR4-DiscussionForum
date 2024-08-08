# Discussion Forum Web Project

This project is a simple discussion forum web application developed using PHP, following the Onion Architecture and leveraging Dependency Injection principles. It was created as part of the coursework for the Software Engineering program at the University of Applied Sciences Upper Austria.

## Features

- **User Authentication**: Registration and login functionality for users.
- **Discussion Topics**: Users can create and participate in discussion topics.
- **Posting to discussion topics**: Users can make posts for each discussion topic.

## Technologies Used

- **PHP**: Backend development
- **Onion Architecture**: For maintaining a clean separation of concerns and enhancing maintainability.
- **Dependency Injection**: For promoting loose coupling and making the application more testable.

## Project Structure

The project is structured according to the Onion Architecture, which includes:

- **Application**: The application’s domain models and business logic.
- **Infrastructure**: Data access, external services, and other low-level concerns.
- **Presentation**: User interface and controllers.

## Requirements

- PHP 7.4+
- Composer
- MySQL or compatible database

## Setup

1. Clone the repository.
2. Run `composer install` to install dependencies.
3. Configure the `.env` file with your database credentials.
4. Run the SQL scripts located in the `database/` directory to set up the necessary tables.
5. Start the PHP server using `php -S localhost:8000`.

---

Developed as part of the Software Engineering studies at the University of Applied Sciences Upper Austria.
