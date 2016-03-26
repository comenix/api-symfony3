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

Rebuild database
```
bin/console Hip:rebuild_database --runtests dev
```


### Routes

**Public Pages**
- http://api.hiphiparray.dev/app_dev.php/1.0/menu
- http://api.hiphiparray.dev/app_dev.php/1.0/posts
- http://api.hiphiparray.dev/app_dev.php/1.0/posts/1
- http://api.hiphiparray.dev/app_dev.php/1.0/pages/1
- http://api.hiphiparray.dev/app_dev.php/1.0/docs

**Secure Pages**
- http://api.hiphiparray.dev/app_dev.php/1.0/secures/1
- http://api.hiphiparray.dev/app_dev.php/1.0/profiles/1

**Admin Pages**
- http://api.hiphiparray.dev/app_dev.php/1.0/users/1
- http://api.hiphiparray.dev/app_dev.php/1.0/contents/1


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
http://api.hiphiparray.dev/doc
```

### Authentication Notes

- See https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md



### Packages


**friendsofsymfony/rest-bundle**
- This Bundle provides various tools to rapidly develop RESTful API's with Symfony
- https://packagist.org/packages/friendsofsymfony/rest-bundle


**jms/serializer-bundle**
- Allows you to easily serialize, and deserialize data of any complexity
- https://packagist.org/packages/jms/serializer-bundle


**nelmio/api-doc-bundle**
- Generates documentation for your REST API from annotations
- https://packagist.org/packages/nelmio/api-doc-bundle


**doctrine/doctrine-migrations-bundle**
- Symfony DoctrineMigrationsBundle
- https://packagist.org/packages/doctrine/doctrine-migrations-bundle


**willdurand/hateoas-bundle**
- Integration of Hateoas into Symfony2
- https://packagist.org/packages/willdurand/hateoas-bundle


**friendsofsymfony/user-bundle**
- Symfony FOSUserBundle
- https://packagist.org/packages/friendsofsymfony/user-bundle


**lexik/jwt-authentication-bundle**
- This bundle provides Json Web Token (JWT) authentication for your Symfony REST API
- https://packagist.org/packages/lexik/jwt-authentication-bundle


**flow/jsonpath**
- Used for codeception api testing
- JSONPath implementation for parsing, searching and flattening arrays
- https://packagist.org/packages/flow/jsonpath


**doctrine/doctrine-fixtures-bundle**
- Symfony DoctrineFixturesBundle
- https://packagist.org/packages/doctrine/doctrine-fixtures-bundle


**codeception/codeception**
- BDD-style testing framework
- https://packagist.org/packages/codeception/codeception

