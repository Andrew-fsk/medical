Install:

cd medical  
composer install    
npm install     
npm install @symfony/webpack-encore --save-dev  
npm run dev     
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
