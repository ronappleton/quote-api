# Avrillo Conveyancing Technical Test

## Introduction

This repository contains the code for the Avrillo Conveyancing Technical Test.
The test is to create a simple quote API that returns Kanye West quotes utilising the [Kanye Rest API](https://kanye.rest/).

## Installation and Setup

To install the project please run the following commands in a directory of your choice:

```bash
composer create-project --stability=dev ronappleton/quote-api quote-api

cd quote-api

vendor/bin/sail up -d
```

Once sail has finished building the containers, run the following command to migrate the database:

```bash
vendor/bin/sail artisan migrate
```

Once the database has been migrated, run the following command to populate the database with quotes:

```bash
vendor/bin/sail artisan quotes:cache
```

You may then access the API at http://localhost/api/quotes?api_token=1234567890

The API token is set in the .env file and is set to 1234567890 by default.
You can also set the API token in the .env file to any value of your choice.

## Testing

In order to run the tests, run the following command after building the containers:

```bash
vendor/bin/sail artisan test
```

## Methodology

### kanye.rest API

On investigation of the kanye.rest API, it was found that the API returns a single quote in a JSON format.
The API is a simple GET request to the endpoint https://api.kanye.rest. The API returns a single quote in the following format:

```json
{
    "quote": "I feel like I'm too busy writing history to read it."
}
```

The requirements of the test is to create a simple quote API that returns Kanye West quotes.
The API should return 5 random quotes, and should be refresh-able to return 5 more random quotes.

This poses an initial problem as the kanye.rest service only returns a single quote per request.

To account for this problem I will create a command that may be ran initially on application setup
to populate a database with quotes from the kanye.rest API. This will allow the API to return 5 random quotes
The command would also be able to be scheduled to run at a set interval to keep the database up to date with new quotes.

The API must be able to refresh the returned 5 random quotes, this is simply the function of the endpoint for getting quotes
so will be considered the refresh function.

The use of cache is allowed in this test, so I will utilise the cache to store the quotes returned from the database to
allow for faster retrieval of the quotes.

### Authentication

The test requires that the API is secured with authentication without using a package.

The API will be secured with a simple API token.

For this I will add an API_TOKEN to the env file and use in the auth config file.

A Middleware will be used to check the API token on each request to the API. The Middleware will check the token against
the config and allow the request to continue if the token is valid. Otherwise the request will be rejected with a 401
response.

### API Client

The test details that the use of Laravel's Manager Pattern is a plus, so I will utilise this pattern when creating
the API Client. This will allow extensibility of the API Client to allow for the use of other API's in the future.

### Testing

The test details the usage of feature tests, so I will create feature tests for the API endpoint.
The test details that unit tests are a nice to have, so I will create unit tests for the API Client
and Manager Pattern and extend the endpoint test to test the authentication middleware.

I will commence the build by writing those tests first, and then writing the code to pass the tests.
