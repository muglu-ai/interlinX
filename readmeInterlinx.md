## InterlinX (BTS) — CodeIgniter 3 Application

### Overview
InterlinX is a matchmaking/partnering tool built on CodeIgniter 3 (MVC). The app uses server‑rendered views with a common layout, session‑based authentication, MySQL for persistence, and configurable routes for search, messaging, and scheduling features.

### Tech stack
- PHP (recommended PHP 7.3+)
- CodeIgniter 3
- MySQL (mysqli driver)
- jQuery + AdminLTE for UI

### App layout
- `index.php`: Front controller and CI bootstrap
- `system/`: CodeIgniter core
- `Taai/`: Application folder (CI “application” dir)
  - `config/`: `config.php`, `database.php`, `routes.php`
  - `controllers/`: `Auth.php`, `Home.php`, `Schedule.php`, etc.
  - `core/`: `Base_Controller.php` (shared controller utilities)
  - `models/`: Domain models (friends, messages, meetings, etc.)
  - `v-t3j45w1n!/`: Views (custom views folder)
    - `layouts/index.php`: Global layout (header, footer, content slot)

### Request flow (high level)
1. Web server routes requests to `index.php` (ENVIRONMENT set via `$_SERVER['CI_ENV']`).
2. CI boots, loads config and `Taai/config/routes.php`.
3. Router maps URL to controller method (default: `Auth`).
4. Controllers extend `Base_Controller`, enforce session, load models, build `$this->response`.
5. `display_template('view')` renders the view into `layouts/index`.

### Configuration
- Base URL: dynamic
  - `Taai/config/config.php` → `'$config['base_url']'` is built from request host and scheme.
  - `'$config['index_page'] = ''` (requires web‑server rewrite to `index.php`).
- Environment:
  - `index.php` → `ENVIRONMENT = $_SERVER['CI_ENV'] ?? 'production'`
  - Use `CI_ENV=development` during local development for verbose errors.
- Database:
  - `Taai/config/database.php` → `$active_group = 'default'`
  - Update `hostname`, `username`, `password`, `database` for your environment.
  - Query Builder is enabled.
- Sessions:
  - `Taai/config/config.php` → `sess_driver=files`, `sess_expiration=7200` (2h), `sess_save_path = sys_get_temp_dir()`
  - `index.php` sets PHP session cookie with `SameSite=None; Secure` and a specific cookie domain. Adjust the domain for your deployment.
- Security & logging:
  - Global XSS filtering enabled (`global_xss_filtering = TRUE`)
  - CSRF protection currently disabled (`csrf_protection = FALSE`) — consider enabling for forms.
  - Logs: `log_threshold = 4`, `log_path = logs/` (ensure writable).

### Routing (selected)
See `Taai/config/routes.php` for full list.
- Default: `auth` (`/` → `Auth::index`)
- Auth: `/index`, `/logout`, `/forgot-password`
- Home and search: `/home`, `/search`, `/search-by-name`, `/search-by-industry-sector`, `/search-by-org`, `/search-by-country`, `/search-by-keyword`, `/search-by-turnover`
- Messages: `/messages/*` (inbox, read, sent, compose)
- Schedule: `/my-calendar`, `/sent-meeting-request`, `/received-meeting-request`, `/set-meeting-status/{id}/{status}`
- Notifications: `/notifications` (polled by the layout every 4s to update counts)
- Simple API endpoints: `/login`, `/profile-update`, `/user-meetings`, `/user-sent-meetings`, `/user-received-meetings`, `/user-set-meeting-status/{...}`

### Auth/session flow
- `Base_Controller::is_user_valid_session()` enforces login for protected routes and redirects guests to the default route.
- `Home` and most feature controllers call this guard in `__construct()`.

### Prerequisites
- PHP 7.3+ (recommended; app sets SameSite cookie options)
- MySQL 5.7+ (or compatible)
- Web server with URL rewriting (Apache or Nginx)

### Local setup
1. Clone the repository into your web root.
2. Configure web‑server rewrite to route all requests to `index.php`.
3. Create a MySQL database and user.
4. Copy/update credentials in `Taai/config/database.php` (default group).
5. Set correct folder permissions:
   - `logs/` writable by the web server
   - PHP `sys_get_temp_dir()` writable for session files (or set a custom absolute path in `sess_save_path`)
6. If using a custom domain locally, adjust the session cookie domain in `index.php` (or remove domain attribute for host‑only cookies).
7. Optionally set `CI_ENV=development` in your virtual host or `.htaccess`/server config.

### Web‑server rewrite examples
Apache (`.htaccess`):
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
```

Nginx (server block):
```nginx
location / {
  try_files $uri $uri/ /index.php?$query_string;
}
```

### Common pitfalls
- 404 for routes: ensure rewrites are enabled and `index_page` remains empty (`''`).
- Session not persisting: check cookie domain/HTTPS/`SameSite=None` alignment, and file permissions for session storage.
- Blank pages in production: set `CI_ENV=development` temporarily to surface errors, or tail the files in `logs/`.

### Deployment notes
- Update `Taai/config/database.php` with production credentials.
- Ensure `logs/` is writable; rotate logs in production.
- Review `index.php` cookie domain and `secure` setting for your site’s domain and HTTPS.
- Consider enabling `csrf_protection` for forms.

### License
The CodeIgniter framework is MIT‑licensed. Application code license is as per your project’s policy.


