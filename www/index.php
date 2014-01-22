<?php

//define the api url
define('OAUTH_HOST', 'http://lavaapi.qwkpy.com/'); ///replace this with your own
//define the callback url this is the same as the application url

//replace this with your own note since this a server application you cannot use the oob option
//oob (Out of Band)
define('CALLBACK_URL', 'http://localhost:8000');
//include the autoload script
require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;

//define the config array
$config = array(
    'consumer_key' => trim('oauth consumer key'), //replace this with your own
    'consumer_secret' => trim("oauth consumer secret"), //replace this with your own
    'server_uri' => OAUTH_HOST,
    'request_token_uri' => OAUTH_HOST . 'account/oauth/token',
    'authorize_uri' => OAUTH_HOST . 'account/oauth/authorize',
    'access_token_uri' => OAUTH_HOST . 'account/oauth/access_token'
);

//create the application instance this helps us manage objects in this application 
//it also provides helpfull helpers 
$app = new Application();
//create a sharable client 
$app['client'] = $app->share(function() {
            return new Client(OAUTH_HOST);
        });
//we will be using twig for the template
$app->register(new Silex\Provider\TwigServiceProvider(),
        array(
    'twig.path' => __DIR__ . '/../views',
));

//registering the session service provide provided by silex
$app->register(new Silex\Provider\SessionServiceProvider());

//this handles the index for the request
$app->get('/',
        function(Application $app, Request $request) use($config) {
//initialize the 
            OAuthStore::instance("Session", $config);

            $data = $request->get("oauth_token");

            if (empty($data)) {
                //get a request token 
                $tokenResultParams = OAuthRequester::requestRequestToken($config['consumer_key'], 1);

                $token = $tokenResultParams['token'];

                $app['session']->set('token', $token);

                $querystring = http_build_query(array('oauth_token' => $tokenResultParams['token'],
                    'oauth_callback' => CALLBACK_URL));

                return $app->redirect($config['authorize_uri'] . '?' . $querystring);
            }
            else {

                $tokenResultParams = $_GET;
//request for access tokens 
                OAuthRequester::requestAccessToken($config['consumer_key'],
                        $tokenResultParams['oauth_token'], 1, 'POST', $_GET);
//retrieve the tokens from storage(session)

                $tokens = $_SESSION['oauth_' . $config['consumer_key']];
//uncomment this line to inspect the object returned
//                echo '<pre>';
//                print_r($tokens);
//now lets get the user object from the api
//now lets get our guzzle client defined above
                /* @var $client Client */
                $client = $app['client'];

//configure the guzzle oauth plugin
                $client->addSubscriber(new Guzzle\Plugin\Oauth\OauthPlugin(array(
                    'consumer_key' => $tokens['consumer_key'],
                    'consumer_secret' => $tokens['consumer_secret'],
                    'token' => $tokens['token'],
                    'token_secret' => $tokens['token_secret']
                )));

//here we query the account/user url to get the user object
                $user = $client->get('account/user')->send()->json();





                return $app['twig']->render('index.twig',
                                array('tokens' => $tokens, 'user' => $user));
            }
        });

$app->get('login',
        function(Application $app) {

            return $app['twig']->render('form.twig');
        });


$app['debug'] = true;




$app->run();




