# Project Name

A product management system in PHP using Laravel, with features to create, update, view and delete products. The system allows you to upload photos for products and stores this information in a MySQL database.

## Technologies Used

- **PHP**: Programming language
- **Laravel**: PHP framework
- **Postgres**: Database management system
- **Docker**: Container platform
- **PHPUnit**: PHP automated testing framework

## Prerequisites

Before you start, you need to have the following tools installed on your machine:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/) (optional, if you want to install dependencies manually)

## Installation

### 1. Clone the repository

Clone the repository on your local machine:

```bash
git clone https://your-repository.git
cd your-repository

Create a .env file from the .env.example file:
Configure Docker
Edit the docker-compose.yml file as needed to adjust database settings, ports, or other dependencies.
Start Docker with the following command:
docker-compose up -d
This will start the containers in the background.

5. Install Composer dependencies
If Composer is not running inside the container, run:

If everything goes well, the application will run at http://localhost/api/{route name}
