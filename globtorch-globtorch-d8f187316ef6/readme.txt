STEPS TO SET UP LARAVEL FROM BITBUCKET

1. clone the git repository - on bitbucket go to the globtorch group using the icon that looks like a person on the bottom left corner of the screen. Once you're in, click the repository. Then you can clone the repository using the clone button on the top right of the screen or you could press the '+' sign that's on the top left of the screen.
2. run 'composer install' to settle the dependencies
3. rename .env.example to .env
4. run 'php artisan key:generate'
5. give read, write permissions to storage if you see the error about not being able to access storage.
 
 You should now see the Laravel page when you open your browser to the public folder of the application.