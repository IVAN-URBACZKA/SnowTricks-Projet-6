# snowTricks
 Project 6 of my course PHP / Symfony application developer at OpenClassrooms. Creation of a community site for sharing snowboard figures via the Symfony framework.

# Codacy
https://app.codacy.com/manual/IVAN-URBACZKA/snowTricks/dashboard

# Download or clone the repository git

https://github.com/IVAN-URBACZKA/snowTricks

2 - Download dependencies :

composer install

3 - Create database :

php bin/console doctrine:database:create

4 - Create schema :

php bin/console doctrine:schema:update --force

5 - Load fixtures :
php bin/console doctrine:fixtures:load
