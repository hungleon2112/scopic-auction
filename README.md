# scopic-auction

Please note that the Date Time of system is set at UAT
In admin Login Page or Dashboard, I implement a small script to show a clock, please note when set Auction on the Item and run Schedule
to check Deadline Auction

I) To run Backend / API
	1) Open Terminal 1
	2) cd auction
	3) composer install
	4) php artisan migrate
	5) php artisan migrate --seed
	6) php artisan serve
	7) Open Terminal 2
	8) cd auction
	9) php artisan queue:restart && php artisan queue:work
	10) Open Terminal 3
	11) TO RUN SCHEDULE (CHECK DEADLINE AUCTION): php artisan schedule:run
	l2) SWAGGER: http://localhost:8000/swagger
	13) http://localhost:8000

II) To run Storefront
	1) Open Terminal 4
	2) cd storefront
	3) npm install
	4) npm start
	5) http://localhost:8080
	
III) Mailtrap.io credentials:
	viethung.nguyen.2112@gmail.com / Aa123456789
	Because I don't have paid account, so please go to my Demo Inbox, you can see the email come from system.
	
IV) Admin credentials:
	admin/admin
	
V) Please paste this to .env file in auction root folder

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:owne6hz5hkpcC9ZxGfFXsgNP09eLys/A1NCwtKW3xfE=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auction
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=04c0cc0b96cc01
MAIL_PASSWORD=da0afd44cc3cd2
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="viethung.nguyen.2112@gmail.com"
MAIL_FROM_NAME="Leo"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=ECLNgXIZG4H8ZZBbM6R4q91TSX9o7B8hXgxUhNr3VNt0vYB9EtjHHuti50szuR5T
