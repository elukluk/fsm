# Finite State Machine
The implementaion approach in this asseement is using a callback function for setting the transition states as suggested in the Advanced Exercise. The function parameters can also be implemented configured using setter functions in the class with data validation.

An example of API class usage is included in demonstrated in the ModThree.php.

# System requirement: PHP 8.1+

# Run the demo without Docker:
In a terminal:

run: `composer install`

run: `php ./src/ModThree.php` to see the demo results

run: `vendor/bin/phpunit` to see the unit testing results

# Run unit testing and modThree demo in Docker:
run: `docker-compose build`

run: `docker-compose up` (the image `policyreporter-fsm-php` will be created)