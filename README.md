Hip Hip Array API
===========



Security Check
```
php bin/console security:check
```

Symfony show all routes
```
php bin/console debug:router
```

Symfony clear cache
```
bin/console cache:clear --no-debug --env=prod
bin/console cache:clear --no-debug --env=dev
```


### Database


Build database
```
sudo -u www-data bin/console doctrine:migrations:status
sudo -u www-data bin/console doctrine:migrations:migrate
```

Load fixtures
```
bin/console doctrine:fixtures:load -n --env=dev
```



### Testing Setup


install phantomjs

```bash
cd bin/phantomjs
wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
tar jxvf phantomjs-2.1.1-linux-x86_64.tar.bz2
cp phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin/
chmod +x /usr/local/bin/phantomjs
```

start/stop phantomjs

```bash
bin/phantomjs/start.sh
```


Config
```
cp codeception.yml.dist codeception.yml
```


Run build after updating yml files (eg. adding a module to `unit.suite.yml`)
```
vendor/codeception/codeception/codecept build
```



### Running Tests

```
vendor/bin/codecept run unit
vendor/bin/codecept run api
```


### Register test with Postman


POST
- http://api.hiphiparray.dev/app_dev.php/1.0/registers

Headers
- Accept application/json
- Content-Type application/json

Body (raw)
```json
{"email":"test@example.com","username":"tester","plainPassword":{"first":"password","second":"password"}}
```


### Json Web Token Authentication


#### SSH keys

Generate SSH keys

```bash
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
```


#### Get the token

POST
- http://api.hiphiparray.dev/app_dev.php/1.0/login_check

Headers
- Accept application/json
- Content-Type application/json

Body (raw)
```json
{"_username":"tester","_password":"password"}
```

#### Use the token

GET
- http://api.hiphiparray.dev/app_dev.php/1.0/contents/1

Headers
- Accept            application/json
- Content-Type      application/json
- Authorization     Bearer {token}


### API Docs

```
http://api.hiphiparray.dev/api/doc
```

### Authentication Notes

- See https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md
