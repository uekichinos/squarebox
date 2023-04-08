
# SquareBox

SquareBox is a Laravel CMS Boilerplate.

- Users 
    - User impersonation
    - "I'm online" status
- Roles and Permissions 
    - Configure default role upon register
- Google analytics
    - Tracking both web and/or admin page
- Announcement
    - Start date and end date
    - Auto disable once reach end date
- Maintenance page
    - Email secret token to admins when page is under maintenance
- Password
    - Configure password strength
    - Password history
    - Cold down period
- Header
    - Configure application name and image/logo
- Browser Agent
    - Capture browser agent type
- Application log
    - Manage laravel application logs

## Installation

```bash
  php artisan key:generate
```

```bash
  php artisan storage:link
``` 

```bash
  composer install
``` 

```bash
  php artisan migrate --seed
``` 

Configure your server to run the scheduler. For more info https://laravel.com/docs/10.x/scheduling#running-the-scheduler.

## Login Detail
email: admin@localhost.com

password: admin123