# PeguePague Transaction API

Dependencies: PHP7.4, Composer, Redis, MySQL

## Setup

### Install dependencies

```bash
cd peguepague
composer install
```

## Run with docker

```bash
docker-compose up
```

## Usage

### Registration
There is a simple post method for registering users:

* Common User

```bash
curl --location --request POST 'localhost:8080/api/v1/users' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Common user",
    "email": "common@user.com",
    "password": "asdfasd",
    "document_type": 1,
    "document": "asdfa",
    "user_type": 1
}'
```

* Shopkeeper

```bash
curl --location --request POST 'localhost:8080/api/v1/users' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Lojista",
    "email": "lojista@user.com",
    "password": "asdfasd",
    "document_type": 2,
    "document": "asdfa",
    "user_type": 2
}'
```

### Transactions
* Transfer R$200,00 from user 1 to user 2:

```bash
curl --location --request POST 'http://localhost:8080/api/v1/transaction' \
--header 'Content-Type: application/json' \
--data-raw '{
    "payer": 1,
    "payee": 2,
    "value": 200
}'
```

* Bad request attempting to transfer R$200,00 from user 2 (a shopkeeper) to user 1:

```bash
curl --location --request POST 'http://localhost:8080/api/v1/transaction' \
--header 'Content-Type: application/json' \
--data-raw '{
    "payer": 2,
    "payee": 1,
    "value": 200
}'
```

### Helpers
* List users:

```bash
curl --location --request GET 'http://localhost:8080/api/v1/users'
```

* List transactions

```bash
curl --location --request GET 'http://localhost:8080/api/v1/transactions'
```