Usage
=====

Step 1
~~~~~~

Follow the :ref:`installation` procedure.

Step 2
~~~~~~

Configure the configuration files accordingly and the security of your Symfony
application.

Step 3
~~~~~~

Get a valid token from your front-end application.

Step 4
~~~~~~

- Make a request to ``/api/user`` with the ``Authorization`` header.

``curl -X GET "http://127.0.0.1:8000/api/user" -H "Authorization: pop <insert-token-here>"``
