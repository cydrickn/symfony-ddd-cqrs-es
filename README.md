## DDD CQRS ES Boilerplate for Symfony

A Boilerplate that uses Domain Driven Design, Command Query Responsibility Segregation and
Event Sourcing for symfony.

## How to install

```bash
composer create-project cydrickn/symfony-ddd-cqrs-es
```

## Run using docker

```bash
cd opt/
docker-compose up -d
```

Run migration when all container are ready

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate
```

Now you can access the site using http://localhost:8080/

You can access the api doc using http://localhost:8080/api/doc