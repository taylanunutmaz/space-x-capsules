# Space-X-Capsules

## About Space-X-Capsules

Space-X-Capsules are mirror of SpaceX API Capsule Datas. Datas pull every three minutes. Also includes API Documentation in `https://{your.domain}/api/documentation`.

You Can access `tbl:01` endpoints replacing `https://api.spacexdata.com/v3/` with `https://{your.domain}/api/`.

`tbl:01`

| Name | Link |
| ---| --- |
| Get All Capsules API | [https://api.spacexdata.com/v3/capsules](https://api.spacexdata.com/v3/capsules) |
| Get Capsules By Status API | [https://api.spacexdata.com/v3/capsules?status=active](https://api.spacexdata.com/v3/capsules?status=active) |
| Get Capsule By Serial API | [https://api.spacexdata.com/v3/capsules/C112](https://api.spacexdata.com/v3/capsules/C112) |

## How To Setup

```bash
git clone https://github.com/taylanunutmaz/space-x-capsules.git
cd space-x-capsules

# Do not forget to arrange your .env file with valid database
cp .env.example .env

composer install
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan l5-swagger:generate
php artisan space-x:sync-capsule-data
php artisan serve
```

## How To Use

* Go to documentation url `/api/documentation` (if you are using Laravel Develoment Server: http://127.0.0.1:8000/api/documentation).

* Register

  * Use POST /api/register.

* Login

  * If you want to use JWT, you can use POST /api/login and click Authorize button top right and paste it `bearerAuth` section with `Bearer {Your JWT}`.

  * Also you can use passport(OAuth2) to login. Click on Authorize button top right. If your APP_DEBUG is true in .env file `client_id` and `client_secret` will fill automatically. You can login with using your login credentials.
