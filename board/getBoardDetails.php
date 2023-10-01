<!--
    This function returns a randomly generated board from the generator.
-->
<?php
    // curl to generator for new grid
    $requestURI = "http://" . $_SERVER["SERVER_NAME"] . "/word-search-generator/generator";
    $request = curl_init($requestURI);

    curl_setopt($request, CURLOPT_RETURNTRANSFER, true); // to get response back
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, true); // deployment server redirects http to https

    $result = curl_exec($request);

    // interpret curl result
    if ($result) {
        http_response_code(200);
        echo $result;
    } else {
        http_response_code(500);
        echo "could not fetch word search board from generator. Curl error: " . curl_error($request);
    }

    curl_close($request);
?>