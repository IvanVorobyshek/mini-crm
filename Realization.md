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

8. FormRequests 
 - CreateTicketRequest - public request
 - FilterTicketRequest - admin, manager
 - UpdateTicketStatusRequest - admin, manager

9. API Resources (Ticket, TicketCollection, Statistics)

10. API Controllers (store ticket, update ticket status, statistics)
 - API routes 
 - fix for Exception folder
 - Sanctum module (but api routes without auth)

11. Widget
 - Controller
 - Blade
 - Vite (styles, js)

12. Admin Panel
 - Middleware
 - AdminController
 - AdminPanel (login, tickets pages)
 - Statistics

13. Information files
 - Readme.md (quick start, short description)