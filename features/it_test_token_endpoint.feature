Feature: It test the /api endpoint

    Scenario: Test

    Given I am on "/token"
    Then the response should be in JSON
    Then the JSON node "token" should not be null

    Given I send a POST request to "/token" with body:
        """
        {"foo":"bar"}
        """
    Then the response should be in JSON
    Then the JSON node "token" should not be null
