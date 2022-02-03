Feature: It test the /api/user endpoint

    Scenario: Test

    Given I add "Authorization" header equal to "foo"
    When I send a GET request to "/api/user"
    Then the response status code should be 401

    Given I add "Authorization" header equal to "pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUp6ZFdJaU9pSjFjMlZ5WHpZd09Ea3hNREUyWkdFNVlqSWlMQ0poWTNScGRtVWlPblJ5ZFdWOS51SkhMLWxJdUVOVlFqVE9hM3dWQVFQVlI1am9uY3VTb3RpTURBM3o1VFpFIn0.r1mDS0qCjy_4a-XXD6SPPgDQd9McDDvZFJfRxq2Xwn4"
    When I send a GET request to "/api/user"
    Then the response should be in JSON
    Then the JSON node "sub" should not be null
    Then the JSON node "active" should be equal to "true"
    Then the response status code should be 200

    Given I add "Authorization" header equal to "pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUptYjI4aU9pSmlZWElpTENKemRXSWlPaUoxYzJWeVh6WXdPRGt4TWpBek4yTmtOV0VpTENKaFkzUnBkbVVpT25SeWRXVjkuU0JaSDNMNEVkcHk4NWlITHVDcVpWTkQxSDltYU9UZERjZUF2bXF3NFp4byJ9.eVRIsRLwFNoCRNsiCyVEfhPze4sjx9DKl-RJ9mwkZEQ"
    When I send a GET request to "/api/user"
    Then the response should be in JSON
    Then the JSON node "sub" should not be null
    Then the JSON node "active" should be equal to "true"
    Then the JSON node "foo" should be equal to "bar"
    Then the response status code should be 200


