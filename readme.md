#Lava Api example using PHP

##Getting familiar with oauth

Before starting take a look at [Oauth 1 specification](http://oauth.net/core/1.0/)

##Register as A developer on lava

Register as a developer on lava and get your application tokens 
[Register application ](http://lavaapi.qwkpy.com/)


###install composer 

[Composer instalation ](http://getcomposer.org/download/)

###Install dependencies

``` php composer.phar update ```

this will install all the required libraries and set them up for you 
> NB: svn is needed to be installed on your system in order to install the oauth-php library 
> also  git needs to be installed to install source packages  

###configure the index.php at www

>replace all the values that are marked REPLACE THIS with your own required values

##start the server
if using apache the document root should be the www sub folder if using php 5.4 and above 
cd into the directory and run 

``` php -S localhost:8000 -t www ```

> now point your browser to  localhost:8000 or your server url 

This example uses the oauth-php library found on http://code.google.com/p/oauth-php/ for authentication

It also uses the guzzle php library with the oauth plugin http://guzzlephp.org/#

It  also uses the twig library http://twig.sensiolabs.org/ and the silex microframework http://silex.sensiolabs.org/ 
