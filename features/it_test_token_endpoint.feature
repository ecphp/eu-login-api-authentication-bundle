Feature: It test the /api/token endpoint

    Scenario: Test

    Given I am on "/api/token"
    Then the response should be in JSON
    And the JSON node "token" should not be null

    Given I send a POST request to "/api/token" with body:
        """
        {"foo":"bar"}
        """
    Then the response should be in JSON
    And the JSON node "token" should not be null
