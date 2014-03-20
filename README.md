# Mirage 
## Temporary Folder Generator for Laravel4

Mirage is a laravel 4 package for creating temporary folder during an application request, which can be useful in plenty of user case.

### Installation

Add this into `require-dev` in your `composer.json` file:

```
"require-dev" : {
	...
	"plateau/mirage": "dev-master"
}
```

Run an update:

```
php composer.phar update
```

Register the console service provider in `app/config/app.php`:

```php
'providers' => array(
	...
	'Plateau\Mirage\MirageServiceProvider',
);
```

Register the facade :
```
	'Mirage' => 'Plateau\Mirage\MirageFacade'
```

### Usage

By default Mirage will create the temporary folders in /app/storage/temp , but feel free to override the config by publishing it :

```
php artisan config:publish plateau/mirage
```

To request a folder : 

```
$temporaryFolder = Mirage::request();
```

Mirage will then generate a 32 characters random string and will schedule an event to delete it at then end of the Laravel application's lifecycle, so it we not be available upon next request.

If you ever need to clean the temporary folder : 
```
Mirage::clean();
```

Happy Coding!
