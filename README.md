## Requirements

- PHP 8.1+
- Composer 2.2+
- NPM 6.14
- MySQL/Postgres database with valid credentials

## Setup

- Clone repository.
- **IMMEDIATELY** - check repository into your github account and then make the changes as a new commit. (This helps us review the code you changed.)
- **Please do not fork the repository.**
- Copy .env.example to .env and configure database settings.
- Run the following commands to get a functional and seeded application:
  ```
  composer install
  php artisan key:generate
  php artisan migrate:fresh
  php artisan db:seed
  npm install
  npm run dev
  php artisan serve
  ```

## Code Challenges

The objectives outlined below should be completed and any resulting code should follow the code style of the project and have doc-blocks where applicable.

- Modify Vue Datatables Owners table structure to include columns for number of addresses and cars associated with each owner.
- Modify Vue Datatables Addresses table structure to include concatenated owner name and number of cars associated with each address.
- Modify Vue Datatables Cars table to include concatenated owner name and address associated with each car.
- Build simple and reusable view/edit Vue.js components for owners, addresses, and cars and link them to the action buttons in each table. The displayed data should include associated entities. (Addresses and cars for the owner. Owner and cars for the address. Owner and address for the cars.)
- Build a simple and reusable delete Vue.js component for owners, addresses, and cars. This should include a confirmation prompt.

## Share Your Solution

-  Upon completion please share the git repository you created in the initial setup steps.
