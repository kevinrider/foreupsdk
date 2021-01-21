<?php

defineConst('FOREUP_SERVER', 'https://private-anon-0375c630cf-foreup.apiary-mock.com');
defineConst('APP_USER', 'devtesting');
defineConst('APP_PASSWORD', 'devtesting1');
defineConst('REQUEST_TOKEN_URL', FOREUP_SERVER . '/api_rest/index.php/tokens');
defineConst('VALIDATE_TOKEN_URL', FOREUP_SERVER . '/api_rest/index.php/tokens/validate');
defineConst('URL_COURSELIST', FOREUP_SERVER . '/api_rest/index.php/courses');
defineConst('URL_CREATE_CUSTOMER', FOREUP_SERVER . '/api_rest/index.php/courses/courseId/customers');
defineConst('URL_GETONE_CUSTOMER', FOREUP_SERVER . '/api_rest/index.php/courses/courseId/customers/customerId');

function defineConst($name,$value)
{
    if (!defined($name))
    {
        define($name, $value);
    }
}