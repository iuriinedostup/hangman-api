hangman-api
===========

RESTful API server for Hangman game

Install
---
1. Clone repo into your path.
2. Setup virtual host to repo/path/api/web and hosts.

    For example: 
        
        <VirtualHost *:80>
        	ServerName api.hangman.local
        	ServerAdmin webmaster@localhost
        	DocumentRoot /var/www/hangman.local/api/web
        	<Directory /var/www/hangman.local/api/web>
        	   AllowOverride All
        	   Order allow,deny
        	   Allow from all
        	   # New directive needed in Apache 2.4.3: 
        	   Require all granted
            </Directory>
        </VirtualHost>

3. Copy config from `application.ini.dist` to `application.ini` in path `/api/Src/Application/Config` and put your settings for DB and service key.
4. Run composer: `php composer.phar install`
5. Load default words. Run command `curl -X GET http://api.hangman.local/service/loadWords/123456`. `123456` - is a service key from `application.ini`.
6. Application ready for use.

How to use
---
1. list all games: `curl -X GET http://api.hangman.local/games`
2. Create new game: `curl -X POST http://api.hangman.local/games`. This returns game ID in JSON response.
3. Get game info: `curl -X GET http://api.hangman.local/games/<ID>`. Returns: id, word, tiers_left, status in JSON response
4. Guess letter: `curl -X POST http://api.hangman.local/games/<ID>?char=<char>`. Returns game info

Description
---
This simple application developed using FrontController pattern and little similar to MVC pattern. There are implemented Unit tests as well.
Also application has routing system, good request and response logic, implemented bootstrap for doing additional actions.
Response can use few providers for convert data. By default application are using JsonProvide, but if needed, can be added any provider. Provider based on interface.
Request can be changed during application process, for example in bootstrap.
Models are implemented with using simple ActiveRecord pattern implementation. For DB used MySQL PDO adapter. There is could be implemented and use another adapter.

In general application are flexible, any developer can add some its own features, adapters, providers, APIObjects and models etc.
