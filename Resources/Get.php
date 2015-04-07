<?php

$app->get(
    '/validate/:user/:repo',
    function ($user, $repo) use ($app) 
    {
        $response['validate'] = true;

        try {
            $app->gitClient->issues->listIssues($user, $repo);
        } catch(\Exception $e) {
            $response['validate'] = false;
        }
        
        $app->response()->header("Content-Type", "application/json");
        echo json_encode($response);  
    }
);
