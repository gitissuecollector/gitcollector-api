<?php

$app->map(
    '/createIssue/:user/:repo',
    function ($user, $repo) use ($app) 
    {
    	try 
    	{
	        $bodyData = json_decode($app->request->getBody(), true);
	       	$response['created'] = false;

	        if (array_key_exists('reporter', $bodyData) && array_key_exists('title', $bodyData) 
	        		&& array_key_exists('body', $bodyData)) 
	        {
	        	$titleMessage 	= $bodyData['title']; 
	        	$bodyMessage 	= $bodyData['body'];
	        	$reporter 		= '['.$bodyData['reporter'].']';

	       		if ((strlen($titleMessage) > 0) && (strlen($bodyMessage) > 0) && (strlen($reporter) > 0)) 
	       		{
	       			$app->gitClient->setCredentials(
	       				\Slim\Extensions\Config::get('github.username'), 
	       				\Slim\Extensions\Config::get('github.password')
	       			);

	       			$app->gitClient->issues->createAnIssue(
	       				$user, $repo, 
	       				$titleMessage, 
	       				$reporter . '/n ' . $bodyMessage
	       			);	

	       			$response['created'] = true;
	       		}
	        } 
	    } catch(\Exception $e) {
	    	$response['created'] = false;
	   	}

		$app->response()->header("Content-Type", "application/json");
        echo json_encode($response);
    }
)->via('OPTIONS', 'POST');
