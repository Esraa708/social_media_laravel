# This is  blog posts where user can:-
 - have friends
 - add posts, comments. replies
 - edit, delete his owen posts, comments,replies
 - find specific friend post
 - home page that displayies all friends posts and of course it is infinite scroll 
 # Technology
    Laravel
    vue.js
# To run the app:-
- create databse add it to the .env file    
- Run php artisan migrate
- composer update
- composer dump-autoload
- php artisan db:seed --class=UserSeeder
- php artisan db:seed --class=PostSeeder
- php artisan db:seed --class=CommentSeeder
- npm install
- npm run dev
- php artisan serve
- password for all seeded users is 1234546
