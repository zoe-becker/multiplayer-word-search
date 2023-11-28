<?php
/* several utility functions to reduce http request validation boilerplate code */

// validateGET: Validates the following:
// 1. The request is a GET request
// 2. The query string contains all of the keys listed in $queryParams
//
// $queryParams: array of query keys that should be in the request
// $quitIfBad: If true and the request is invalid, the http request status will be set to 400 or 405
//    depending on the context. If a query parameter is missing an appropriate message will be echoed
//    to the client
// returns: true if request is valid, false otherwise
function validateGET($queryParams, $quitIfBad = false) {
    $requestValid = true;

    // validate method
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        $requestValid = false;
        if ($quitIfBad) {
            http_response_code(405); // method not allowed
            exit(-1);
        }
    }

    // validate params
    foreach ($queryParams as $param) {
        if (!array_key_exists($param, $_GET)) {
            $requestValid = false;
            if ($quitIfBad) {
                http_response_code(400);
                echo "$param paramter missing.";
                exit(-1);
            }

            break;
        }
    }

    return $requestValid;
}

// validatePOST: Validates the following:
// 1. The request is a POST request
// 2. The request contains all of the headers listed in $requiredHeaders
//
// $queryParams: array of required headers that should be in the request
// $quitIfBad: If true and the request is invalid, the http request status will be set to 400 or 405
//    depending on the context. If a header is missing an appropriate message will be echoed
//    to the client
// returns: true if request is valid, false otherwise

function validatePOST($requiredHeaders, $quitIfBad = false) {
    $requestValid = true;

    // validate method
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $requestValid = false;
        if ($quitIfBad) {
            http_response_code(405); // method not allowed
            exit(-1);
        }
    }

    // validate params
    foreach ($requiredHeaders as $header) {
        if (!array_key_exists("HTTP_" . strtoupper($header), $_SERVER)) {
            $requestValid = false;
            if ($quitIfBad) {
                http_response_code(400);
                echo "$header header missing.";
                exit(-1);
            }

            break;
        }
    }

    return $requestValid;
}

?>