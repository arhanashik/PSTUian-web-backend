
<p align="center"> 
<img src="https://pstuian.com/images/pstuian_featured_photo.png"  />
</p>
<p style="margin-top:-10px;" align="center">The greatest help you can do is by using the website and mobile app. By adding your information to the system you can take us one step further to complete our community.
The next thing you can do to help us is by opening your heart. A small <a href="https://pstuian.com/donation.php">Donation</a> from you can help us a lot. Thousands of hours of work made this website and app a reality. We also have future plans for this. Also there are maintaince cost and other things. We are doing everything for free because we love our university and everyone, same as you.</p>
<p align="center">
<img src="https://media.giphy.com/media/iY8CRBdQXODJSCERIr/giphy.gif" width="30px" style="margin-top:10px;">
<img alt="GitHub repo size" src="https://img.shields.io/github/repo-size/arhanashik/PSTUian-web-backend">
<img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/arhanashik/PSTUian-web-backend">
<img src="https://custom-icon-badges.demolab.com/badge/Larvel-11-860043?logo=laravel&logoColor=white" />
</p>

<br><br>

<details>
<summary><b>Installation Guideline</b></summary>

+ Open Git Bash & run : `git clone https://github.com/arhanashik/PSTUian-web-backend.git` to clone repo
+ Open project in vs code & run : `composer install` or `composer update`
    + If you find error to install compser, for your running php version, then run : `composer install --ignore-platform-reqs` or  Uninstall xampp and again install require xampp( php ) version.
+ Install NPM Dependencies : `npm install`
+ Create a copy of your .env file: `cp .env.example .env`
+ Generate an app key : `php artisan key:generate`
+ Open phpMyAdmin to create a database and also insert database name into .env file
+ Migrate the database : `php artisan migrate`
+ Run project : `php artisan serve`

</details>