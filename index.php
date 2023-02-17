<?php
// Set the Jikan API endpoint
$jikanEndpoint = "https://api.jikan.moe/v3";

// Function to generate a response to a user input
function generateResponse($input) {
    global $jikanEndpoint;

    // Send a search request to the Jikan API to retrieve information about the anime related to the user input
    $searchUrl = $jikanEndpoint . "/search/anime?q=" . urlencode($input);
    $searchResponse = file_get_contents($searchUrl);
    $searchData = json_decode($searchResponse, true);

    // If the search result contains anime, retrieve information about the first anime in the list
    if (!empty($searchData["results"])) {
        $anime = $searchData["results"][0];

        // Generate a response based on the retrieved anime information
        $response = "The anime you're looking for is " . $anime["title"] . ", which was aired from " . $anime["start_date"] . " to " . $anime["end_date"] . ".";
    } else {
        // Generate a default response if no anime is found
        $response = "I'm sorry, I couldn't find any anime related to your input. Please try again with a different query.";
    }

    return $response;
}

// Check if the input variable is set and not empty
if (isset($_POST["input"]) && !empty($_POST["input"])) {
    // Get the user input from the POST request
    $input = $_POST["input"];

    // Generate a response to the user input
    $response = generateResponse($input);

    // Output the response as a string
    echo $response;
}
