

## Chat App

### Prerequisites

Before you start, make sure you have the following installed on your machine:

- Docker
- Docker Compose

## Installation

1. **Clone the repository**:

    ```bash
    cd chat-app
    ```

2. **Copy the `.env.example` file to `.env`**:

    ```bash
    cp .env.example .env
    ```

3. **Update the `.env` file with your database configuration**:

    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=chat_app
    DB_USERNAME=postgres
    DB_PASSWORD=secret
    ```

4. **Build and run the Docker containers**:

    ```bash
    docker-compose up --build
    ```

5. **Run database migrations**:
    ```bash
    docker-compose exec app php artisan migrate
    ```

6. **Compile the assets using npm**:

    ```bash
    docker-compose exec app npm install
    docker-compose exec app npm run dev
    ```


