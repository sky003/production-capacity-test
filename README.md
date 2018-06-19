# Test task

Symfony API route that handles POST request and saves production capacity of a restaurant. POST body is below JSON. API route must come with input validation and unit tests. Focus on code quality and best practices.


Example of request body:
```
{
    "productionCapacities": [
        {
            "amount": 10,
            "productionUnitId": 3,
            "timeUnitId": 1,
            "productGroupId": 56
        },
        {
            "amount": 500,
            "productionUnitId": 5,
            "timeUnitId": 2,
            "productGroupId": 67
        }
    ]
}
```

## Tests

**1. Create `.env` file with your variables.** 

For example:
```
###> symfony/framework-bundle ###
APP_ENV=test
APP_SECRET=fc0d08647faae70a70cff21ebdd9eef5
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL=sqlite:///%kernel.project_dir%/tests/_data/:memory:
###< doctrine/doctrine-bundle ###
```
You actually can use this one. 

**2. Initialize the test environment.** 

Run command to create a database schema
```
$ bin/console doctrine:schema:create
```
and generate codeception actions
```
$ vendor/bin/codecept build
```

**3. Now you can run the tests.**
```
$ vendor/bin/codecept run
```