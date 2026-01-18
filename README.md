Mini-CRM

Realization steps

1. Project Initialization
 - Laravel 12, PHP 8.4, PostgreSQL, MailPit, Redis, xDebug, Laravel debugbar, spatie

2. Database migrations

3. Eloquent Models (User, Customer, Ticket)

4. Factories (User, Customer, Ticket)

5. Seeders (Roles, User, Customer, Ticket). User Factory has been updated. Enums for UserRole and TicketStatus
Execute command to populate DB with data (roles, users, customers, tickets) - ./vendor/bin/sail artisan migrate:fresh --seed

6. Repositories (Interfaces, TicketRepositiry, CustomerRepository)
Only required methods

7. Services, Exceptions
StatisticService methods should be added

