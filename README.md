# Log Project

This project is designed to parse log files and provide a dashboard for log analysis.

## Setup

1. Clone the repository:
   
2. Install dependencies using Composer:
   composer install
3. Set up the database:
- Ensure that your database server is running.
- Configure the database connection in the `.env` file.
- Create the database and run migrations:
  ```
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
4. Start the Symfony server:
   symfony serve

## Usage

- **Parsing Log Files**: 
To parse and save log files, execute the following command:
php bin/console app:parse-log-files

## Endpoints

- **Count Logs**:
- Endpoint: `/count`
- Method: GET
- Parameters:
  - `serviceNames`: Filter logs by service names (optional)
  - `statusCode`: Filter logs by status code (optional)
  - `startDate`: Filter logs by start date (optional)
  - `endDate`: Filter logs by end date (optional)
- Example:
  ```
  GET /count?serviceNames=USER-SERVICE,INVOICE-SERVICE&statusCode=200&startDate=2024-01-01&endDate=2024-12-31
  ```

## Tests

To run tests, execute the following command:
php bin/phpunit    
