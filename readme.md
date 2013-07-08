#Lava Api example using PHP

##Register as A developer on lava

Register as a developer on lava and get your application tokens 
[Register application ](http://lavaapi.qwkpy.com/)


###install composer 

[Composer instalation ](http://getcomposer.org/download/)

###Install dependencies

``` php composer.phar update ```

this will install all the required libraries and set them up for you 
> NB: svn is needed to be installed on your system in order to install the oaut-php library 
> also  git needs to be installed to install the guzzle library 
###configure the index.php at www

replace all the values with 
> replace this with your own required values

##start the server
if using apache the document root should be the www sub folder if using php 5.4 and above 
cd into the directory and run 

``` php -S localhost:8000 -t www ```

> now point your browser to  localhost:8000 

this example uses the oauth-php library found on http://code.google.com/p/oauth-php/ for authentication

it also uses the guzzle php library with the oauth plugin http://guzzlephp.org/#

it  also uses the twig library http://twig.sensiolabs.org/ and the silex microframework http://silex.sensiolabs.org/ 