# translation_management_service

## Setup Instructions
1. Clone the repository
2. Copy .env.example to .env and configure your database settings
3. Run composer install 
4. Run `php artisan migrate`
5. Seed test data: `php artisan translations:seed`
6. Generate API token: `php artisan sanctum:issue-token`
7. Seed user `php artisan db:seed --class=UserSeeder`
8. run project `php artisan serve`

## Endpoints
- POST /api/translations - Create translation
- PUT /api/translations/{id} - Update translation
- GET /api/translations/{id} - View translation
- GET /api/translations/search - Search translations
- GET /api/translations/export - Export JSON
- GET /api/get-token - Token for Test api 

Note : api PostMen Collection Also In root  Translation Management API.postman_collection.json