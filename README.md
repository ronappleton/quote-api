# Avrillo Conveyancing Technical Test

## Introduction

This repository contains the code for the Avrillo Conveyancing Technical Test.
The test is to create a simple quote API that returns Kanye West quotes utilising the [Kanye Rest API](https://kanye.rest/).

## Setup

## Testing

## Changelog

- 2021-08-16 - Initial Framework Commit
- 2021-08-16 - Update the readme.md file to reflect the test.

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

For this I will add a command to the application that will allow the creation of API tokens. The command will generate
a random token and store it in the database. The tokens will be encrypted when stored in the database.

A Middleware will be used to check the API token on each request to the API. The Middleware will check the token against
the database and allow the request to continue if the token is valid. Otherwise the request will be rejected with a 401
response.

For simplicity, I will use uuid's for the tokens, and accept the token as a query parameter on the request.

### API Client

The test details that the use of Laravel's Manager Pattern is a plus, so I will utilise this pattern when creating
the API Client. This will allow extensibility of the API Client to allow for the use of other API's in the future.

### Testing

The test details the usage of feature tests, so I will create feature tests for the API endpoint.
The test details that unit tests are a nice to have, so I will create unit tests for the API Client
and Manager Pattern and the authentication middleware.

I will commence the build by writing those tests first, and then writing the code to pass the tests.


