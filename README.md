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