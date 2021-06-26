## RedCore Solutions Exam

Please add the following configuration to your .env file:

CACHE_DRIVER=redis - Change redis to file if don't want to use redis for cache management

CACHE_PREFIX='redcoresolutions'

MODEL_CACHE_ENABLED=false

MODEL_CACHE_USE_DATABASE_KEYING=true

MODEL_CACHE_STORE='redcoresolutions-cache-model'

JWT_SECRET=HoMfhHJNmF0gjJhgvxlY31oY4xsqIWtgVjisyqWvICeIq4uzAZy9nE3iqm8IBw2Q - JWT KEY or run php artisan jwt:secret to regenerate key

Account List

email: admin@local.com

password: 12345678

email: jane@local.com

password: 12345678

email: johnsmith@local.com

password: 12345678
