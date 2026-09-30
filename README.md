# SwiftPOS — TFA2 Database Integration

SwiftPOS is a CodeIgniter 4 point-of-sale exercise. This TFA2 version replaces the static customer and staff arrays from TFA1 with MySQL-backed `customers` and `users` tables, CodeIgniter models, and Query Builder retrieval.

## Requirements

- PHP 8.2 or later
- Composer 2
- MySQL or MariaDB
- PHP extensions required by CodeIgniter, including `intl`, `mbstring`, and `mysqlnd`/`mysqli`
- Git, for cloning and submission

## Local setup

1. Install the PHP dependencies from the project directory:

   ```bash
   composer install
   ```

2. Create the local environment file:

   ```bash
   cp env .env
   ```

   On Windows Command Prompt, use `copy env .env` instead.

3. Create an empty MySQL database named `swiftpos`:

   ```sql
   CREATE DATABASE swiftpos
       CHARACTER SET utf8mb4
       COLLATE utf8mb4_unicode_ci;
   ```

4. Review the database section in `.env`. The supplied `env` template uses these safe local defaults:

   ```dotenv
   database.default.hostname = localhost
   database.default.database = swiftpos
   database.default.username = root
   database.default.password = ''
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   Change the username and password in your untracked `.env` if your local MySQL installation uses different credentials. Never commit real database passwords or hosted-environment secrets.

5. Build and populate the database using **one** of the following methods.

   **Option A — migrations and seeders (recommended):**

   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

   **Option B — submitted database export:**

   ```bash
   mysql -u root -p swiftpos < database/swiftpos.sql
   ```

   Do not run both methods against the same populated database, because the second method may encounter existing tables or duplicate records.

6. Start the CodeIgniter development server:

   ```bash
   php spark serve
   ```

7. Open [http://localhost:8080](http://localhost:8080).

## Application routes

| Route | Page |
| --- | --- |
| `/` | SwiftPOS dashboard |
| `/about` | About page |
| `/customers` | Customer Accounts, retrieved through `CustomerModel` |
| `/users` | User Accounts, retrieved through `UserModel` |

## Database schema

The table names remain `customers` and `users` to match the laboratory specification. The additional fields preserve the existing interface and make the schema ready for a later authentication activity.

### `customers`

| Field | Purpose |
| --- | --- |
| `id` | Auto-incrementing primary key |
| `full_name` | Required customer name |
| `email` | Required, unique email address |
| `phone` | Optional phone number, up to 25 characters |
| `password_hash` | Password hash storage for future customer authentication |
| `status` | Account status; defaults to `Active` |
| `created_at` | Record creation date and time |

### `users`

| Field | Purpose |
| --- | --- |
| `id` | Auto-incrementing primary key |
| `username` | Required, unique staff username |
| `full_name` | Required staff name |
| `role` | Stored role: `Admin`, `Store Manager`, `Cashier`, or `Inventory` |
| `password_hash` | Password hash storage for future staff authentication |
| `attendance_status` | Staff status; defaults to `Clocked Out` and may represent `Clocked In`, `PTO`, or `AWOL` |
| `is_verified` | Database-backed verification flag; defaults to false |
| `created_at` | Record creation date and time |

Optional values are displayed as `null` when no value is stored.

The User Accounts page derives its display-only access label from the stored role:

| Stored role | Displayed access label |
| --- | --- |
| `Admin` | `Full Access` |
| `Store Manager` | `Management Access` |
| `Cashier` | `View Only` |
| `Inventory` | `Inventory Access` |

## Authentication and sample-data warning

The seeders and SQL export contain demonstration records only. Any sample usernames or password hashes are disposable development data and must not be reused in a real deployment. Password columns store hashes, never plain-text passwords.

This laboratory implements database storage and list display only. It does **not** implement a login form, session authentication, role-based route guards, or permissions enforcement. Roles, verification state, attendance status, and access labels are currently stored and displayed; an `Admin` or `Cashier` label does not yet grant or restrict application actions.

## Troubleshooting

- **`Unable to connect to the database`:** Confirm that MySQL is running, the `swiftpos` database exists, and the credentials in `.env` match the local server.
- **`Table ... doesn't exist`:** Run `php spark migrate` and `php spark db:seed DatabaseSeeder`, or import `database/swiftpos.sql`. Use `php spark migrate:status` to inspect migration state.
- **Duplicate-table or duplicate-record errors:** Start with an empty `swiftpos` database and choose either migrations/seeders or the SQL import, not both.
- **Missing framework classes or `vendor/autoload.php`:** Run `composer install` from the repository root.
- **404 responses:** Use the URL printed by `php spark serve`. For Apache or Nginx hosting, set the document root to the project's `public/` directory.
- **Write-permission errors:** Ensure the web-server process can write to CodeIgniter's `writable/` directory.

## Submission checklist

- [ ] Repository contains the raw CodeIgniter project files.
- [ ] `CustomerModel` and `UserModel` retrieve database records; controllers do not contain static record arrays.
- [ ] Migrations and seeders create at least five records in each required table.
- [ ] `database/swiftpos.sql` is included and can recreate the schema and sample data.
- [ ] Customer and user pages display database records correctly.
- [ ] `.env`, real credentials, and other secrets are not committed.
- [ ] Setup and run instructions have been verified on a clean database.
- [ ] Hosted deployment is live and matches the submitted repository.

## Submission links

- GitHub repository: **TODO — add repository URL**
- Hosted application: **TODO — add hosted URL**
