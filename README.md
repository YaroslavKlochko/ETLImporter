# ETL Importer for AP Automation System

## Overview
This ETL importer loads data from files into a PostgreSQL database for an Accounts Payable (AP) automation system. It handles accounts, vendors, and bank accounts data from JSON format.

## Prerequisites
- **PHP:** v.8.3
- **PostgreSQL:** v.12.16
- **PHPUnit:** v.9.5

## Setup Instructions

1. **Database Setup**
    - Ensure [PostgreSQL](https://www.postgresql.org/download/) is installed and running.
      - Create the database:
    ```sql
    CREATE DATABASE ap_system;
    ```
- Create the tables by running the SQL script provided:
   ```sql
      CREATE TABLE accounts (
      id TEXT PRIMARY KEY,
      number TEXT,
      description TEXT,
      created TIMESTAMP,
      is_active BOOLEAN
      );
      
      CREATE TABLE vendors (
      id TEXT PRIMARY KEY,
      name TEXT,
      short_name TEXT,
      group_code TEXT,
      last_modified TIMESTAMP,
      is_active BOOLEAN,
      currency TEXT,
      terms TEXT,
      contact TEXT,
      address1 TEXT,
      city TEXT,
      state TEXT,
      postal_code TEXT,
      country TEXT,
      phone TEXT
      );
      
      CREATE TABLE bank_accounts (
      id TEXT PRIMARY KEY,
      name TEXT,
      account TEXT,
      currency TEXT,
      last_modified TIMESTAMP,
      is_active BOOLEAN
      );

2. **Configuration**
    - Update the database connection details in **db_configuration.php**. 
   (Make sure to replace ```<host>```, ```<port>```, ```username``` and ```password```  with the appropriate values for your database setup. According to the schema above, the database name should be set to `ap_system`( ```<dbname>:ap_system```). Also, if you are using Postgres, the port should be set to 5432(```<port>=5432```).
    - Ensure the necessary PHP extensions are enabled.(For example PHPUnit that could be set in composer.json)).

3. **Create data folder(or use provided sample data in the project)**
   - First, create a folder with the name ```data```.
   - Inside the data folder, create the following JSON files:
   
   
   ```accounts.json```
   ```json
   [
      {
         "id": "1020100",
         "number": "1020-100",
         "description": "Bank account, operating",
         "created": "2019-01-01T00:00:00",
         "isActive": true
      },
      {
         "id": "1030100",
         "number": "1030-100",
         "description": "Bank account, payroll",
         "created": "2019-01-01T00:00:00",
         "isActive": true
      }
   ]
   ```
   ```vendors.json```
   ```json
   [
     {
       "id": "1234",
       "name": "Goldman Sachs",
       "shortName": "GOLDSACH",
       "groupCode": "INV",
       "lastModified": "1984-04-24T00:00:00",
       "isActive": true,
       "currency": "USD",
       "terms": "DUETBL",
       "contact": "Lloyd Blankfein",
       "address1": "200 West Street",
       "city": "New York",
       "state": "NY",
       "postalCode": "10282",
       "country": "USA",
       "phone": "2129020300"
     },
     {
       "id": "4321",
       "name": "Excide Industrial Batteries",
       "shortName": "EXIDE",
       "groupCode": "INV",
       "lastModified": "2010-08-18T00:00:00",
       "isActive": false,
       "currency": "CAD",
       "terms": "P90",
       "contact": "Mr. J. Everley",
       "address1": "486 Central Blvd",
       "city": "Houston",
       "state": "TX",
       "postalCode": "67182",
       "country": "USA",
       "phone": "7135554799",
       "fax": "7135553201"
     },
     {
       "id": "12345",
       "name": "Vendor New Line Replacer Test",
       "shortName": "VendorNewLineReplacer",
       "groupCode": "CRE",
       "lastModified": "2019-04-30T00:00:00",
       "isActive": true,
       "currency": "CAD",
       "terms": "CREDIT",
       "contact": "John Doe",
       "address1": "address line 1\n\rSuite 300",
       "address2": "address line 2\n\r",
       "address3": "address line 3\n\r",
       "address4": "address line 4",
       "city": "San Diego",
       "state": "CA",
       "postalCode": "92101",
       "country": "USA",
       "phone": "6192321234"
     }
   ]
   ```
   ```bank_accounts.json```
   ```json
   [
     {
       "id": "CCB",
       "name": "City Commercial Bank",
       "account": "1020-100",
       "currency": "USD",
       "lastModified": "2017-01-24T00:00:00",
       "isActive": true
     },
     {
       "id": "PRBANK",
       "name": "Second National Bank",
       "account": "1030-100",
       "currency": "CAD",
       "lastModified": "2013-11-12T00:00:00",
       "isActive": false
     },
     {
       "id": "VISASTB",
       "name": "Visa Seattle Tacoma Bank",
       "account": "1030-100",
       "currency": "USD",
       "lastModified": "2010-08-18T00:00:00",
       "isActive": true
     }
   ]
   ```
   
   4. **Running the ETL Importer**

       - Place your JSON files (`accounts.json`, `vendors.json`, `bank_accounts.json`) in data folder.
       - Create **composer.json**, add missing dependencies and then update it with the command **composer update**:

   ```json
          {
          "name": "test/etl-importer",
          "description": "This is a simple ETL implementation that supports JSON file handling",
          "license": "MIT",
          "require": {
            "php": "^8.3"
          },
          "require-dev": {
            "phpunit/phpunit": "^9.5",
            "ext-pdo": "*"
          },
          "autoload": {
            "psr-4": 
              "App\\": "src/",
              "Tests\\": "tests/"
            }
          }
      ```
   
  - Run the program by using the command:
   ```injectablephp
   php src/Loader/load.php
   ```

## Error Handling and Logging
- The script includes basic error and exception handling and will output messages if any issues occur during the database operations. Currently, there are 5 LOG LEVELS available in the application :```DEBUG```, ```INFO```, ```WARNING```, ```ERROR``` and ```CRITICAL```. Logging output as well as exceptions/errors will be printed in ```app.log```. Also, in ```logger.php``` the retention policy for logs was implemented and can be modified according to the requirements by adjusting **MAX_LOG_RETENTION_DAYS**.

## Coverage with tests
- To run the tests you need to install [PHPUnit](https://phpunit.de/getting-started/phpunit-9.html)(version 9 or higher)
- After that you can run the command to execute the tests:
```phpregexp
vendor/bin/phpunit tests/
```

## Things to improve
- Add support for additional data types such as CSV, XML, Excel and other APIs.
- Implement batching to optimize performance when dealing with large datasets(depends on the amount of data it could be in a range 100-1000 records per batch).
- Replace direct SQL statements with prepared statements to prevent SQL injection attacks.
- Use asynchronous libraries for improved concurrency and performance.(For example, [ReactPHP](https://reactphp.org/), [Amp](https://amphp.org/) or [Swoole](https://openswoole.com/))
- Replace custom logging implementation with the most popular logging libraries. (For example, [Monolog](https://seldaek.github.io/monolog/doc/01-usage.html)(PSR-3 compliant), [Laminas Log](https://docs.laminas.dev/laminas-log/intro/)(PSR-3 compliant) or  [Apache log4php](https://logging.apache.org/log4php/download.html),)
- Use [Docker](https://www.docker.com/products/docker-desktop/) for easier deployment, management and testing.






