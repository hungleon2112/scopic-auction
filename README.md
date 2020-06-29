# scopic-auction
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

II) To run Storefront
	1) Open Terminal 4
	2) cd storefront
	3) npm install
	4) npm start
	
III) Mailtrap.io credentials:
	viethung.nguyen.2112@gmail.com / Aa123456789
	Because I don't have paid account, so please go to my Demo Inbox, you can see the email come from system.
	
IV) Admin credentials:
	admin/admin