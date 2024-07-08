# Composer Installation
## LEARNING NOTE
- Go to this:https://getcomposer.org/download/
- Download
- Install
	- Install for every user
	- The file will be at C:ProgramData/ComposerSetup/bin
- Test your composer
# Laravel (Xampp-PHP) with Composer Installation
- Create basic token in github oauth
- Go to the bin directory of Composer
- Run the command of ```php composer.phar config [--global] --editor --auth```
- If it runs error, create composer.json file with this json object inside
```
{
    "github-oauth": {
        "github.com": "token"
    }
}
```
- Put that very code if notepad is open after the command line command (auth.json)
- Go to xampp bin directory
- Open the php folder and edit the php.ini file
- Search for extension and uncomment the extension=zip
- Go to the laravel project directory
- Use this command (replace the version and the project name):
```cmd
composer craete-project laravel/laravel=[version] [project-name]
```
### LARAVEL FOLDER STRUCTURE
- App : Code Program
- Bootstrap : Process bootstrapping - for laravel initial process (don't change the file)
- Config : All the configuration file
- Database: Database migration
- Lang: Internationalization
- Public: Entry point that will be exposed to the public (executing index.php - and for media too)
- Resources: For code resources (js, css, blade)
- Routes: Endpoint
- Storage: For file storing (example: upload, logging)
- Test: Test files
- Vendor: composer library
- file composer: for composer
- file artisan: to set up artisan/generate laravel
- editorconfig: to make the editor
### ARTISAN
- To execute ```php artisan```
- To run laravel development mode = ```php artisan serve```
	- It is no different than ```php -S localhost:8000``` in /public directory
- To see detail = ```php artisan [command] --help``` (change the command with the real command (serve, make, etc))
	- It will give you the other options too
	- Example options using from detail = ```php artisan serve --port=9090```
### LARAVEL REQUEST LIFECYCLE
- All request goes to public/index.php
	- It makes the other code not accessible via URL
- Request then go to the kernel class
	- There are 2 types of Kernel
		- HTTP Kernel (For HTTP Request - Web Based)
		- Console Kernel (For Console Request - Terminal Based)
	- Kernel directory: app/Http/Kernel.php
	- Kernel is the core of logic, all the request is handled until it gets its response
	- Kernel will pass the request to the Service Provider when it gets the request
- Service Provider
	- Service Provider will do bootsrapping (starting/running) in every component (Database, Queue, Validation, Routing, etc)
	- File: app/Providers/...
		- The important one is RouteServiceProviders (routing) then it goes to route folder
- Route
	- In routing it chooses which file to execute, if it goes to views it will go to views, if it goes to other things it will go to other things
### TESTING
- Laravel will use PHP Unit for testing
	- Unit Test: 
		- Simpler because it doesn't need laravel, just use usual PHPUnit 
		- Create derivative class from PHPUnit/Frameword/TestCase
	- Feature Test/Integration Test
		- Laravel could be used easily
		- Create derivative class from Illuminate/Foundation/Testing/TestCase
		- If we need Laravel code base we use the integration test
		- It will be slower because it will load the laravel first
- How to create test
	- Use php artisan ```php artisan make:test [testName]``` 
		- It will go to folder tests/feature
	- Use php artisan ```php artisan make:test [testName] --unit```
		- It will go to folder tests/unit
- To Run Test = ```php artisan test```
- Run Unit Test: ```vendor/bin/phpunit test/Feature/TestName.php```
- Test method should have prefix testSomething() to be able to be detected by laravel
### ENV
- To get environment variable there are two way
	- env(key)
	- Env::get(key)
- Use Git Bash to add Environment easily = ```export KEY=storedvariable```
- We can add the env in the .env file too
- We can use default value for env (in case env is not present)
	- env(key, default) 
	- Env::get(key, default)
		- Make sure the class is from Illuminate/Support/Env not other class
#### APPLICATION ENVIRONMENT
- APP_ENV is available
	- Options are: local, staging, dev, production, qa
- To Check APP_ENV
	- Single = ```App::environment(value)```
	- More than one = ```App::environment([value1, value2])```
		- App class should be the class of Illuminate/Support/Facades
	- The priority of detected env is phpunit.xml first then .env
### CONFIGURATIOn
- In config folder of laravel folder structure
- Don't change the name of config file, it will change everything
- How to get the config:
	- use function config(key, default)
	- Key in config can be nested
		- filename then key in return value then key in return value ...
		- example: contoh.author.first
	- There are default value too if it is not available
### CONFIGURATION CACHE
- To prevent the read of configuration that is repeating, it will make the app slows down in the future
- To create configuration to be able to be read in minimal time, we need configuration cache
- Here is the configuration cache command ```php artisan config:cache```
- The Cache will be in bootstrap/cache
- To delete cache ```php artisan config:clear```
### DEPENDENCY INJECTIOn
- Use constructor so we can know what class is injected in the target class
```php
class Foo
{
  public function Foo(): string {
    return "Foo";
  }
}

class Bar
{
  private Foo $foo;

  public function __construct(Foo $foo)
  {
    $this->foo = $foo;
  }
  
  public function bar(): string {
    return $this->foo->foo() . " and Bar";
  }
}

//implementation
class DependencyInjectionTest extends TestCase
{
    public function testDependencyInjection()
    {
        $foo = new Foo();
        $bar = new Bar($foo);

        self::assertEquals("Foo and Bar", $bar->bar());

    }
}
```
### AUTOMATIC DEPENDENCY INJECTOR (Service COntainer)
- Dependency management
- Using ```make(key)```
- Using that means it will making new service container (object), be careful not to make too many it will slow down the app
- To create dependency object but we want to have other things to do (example: parameter in constructors) when using make(key), we can use bind(key, closure)
- Closure will get called in every make(key) function call
```php
class ServiceContainerTest extends TestCase
{
    public function testCreateDependency()
    {
        $foo = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo->foo());
        self::assertEquals("Foo", $foo->foo());
        self::assertNotSame($foo, $foo2);
    }

    public function testBind(){
        
        $this->app->bind(Person::class, function($app){
            return new Person("Johntakpor", "Songkali");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Johntakpor", $person1->firstName);
        self::assertEquals("Johntakpor", $person2->firstName );
        self::assertNotSame($person1, $person2);
    }
}
```
### SINGLETON
- Singleton is the object that is created once and then we could refer to it when we want to use it (no need of new object)
- We could use singleton(key, closure)
```php

class SingletonTest extends TestCase
{
  
  public function testSingleton()
  {
    $this->app->singleton(Person::class, function ($app) {
      return new Person('Johntakpor','Songkali');
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Johntakpor", $person1->firstName);
    self::assertEquals('Johntakpor', $person2->firstName);
    self::assertSame($person1, $person2);
  }

}
```
### INSTANCE
- Creating singleton from the object that exists (no need to create a new one)
```php

class InstanceTest extends TestCase
{
  
  public function testInstance()
  {
    $person = new Person('Johntakpor', 'Songkali');
    $this->app->instance(Person::class,$person);

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Johntakpor", $person1->firstName);
    self::assertEquals("Johntakpor", $person2->firstName);
    self::assertSame($person, $person1);
    self::assertSame($person1, $person2);
    
  }
}
```
### AUTOMATIC DEPENDENCY INJECTOR
- Dependency injection is using service provider
- Service provider is ($this->app): the app is the service provider, all the things that is registered in the app is usable
- Then when we have something that needs dependency, the dependency will be injected directly by laravel to our instantiation of object (the service provider or ($this->app) is similar to store in Redux)
```php

    public function testDependencyInjection2()
    {
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertEquals("Foo and Bar", $bar->bar());
        self::assertSame($foo, $bar->foo);
        
    }
```
### DEPENDENCY INJECTION IN CLOSURE
- The $app parameter in closure is the variable that we can access to get all the dependency that is inside the service provider
```php

class ClosureDepInjTest extends TestCase
{
  public function testClosure()
  {
    
    $this->app->singleton(Foo::class, function($app){
      return new Foo();
    });

    $this->app->singleton(Bar::class, function($app){
      return new Bar($app->make(Foo::class));
    });

    $bar1 = $this->app->make(Bar::class);
    $bar2 = $this->app->make(Bar::class);
    
    self::assertSame($bar1, $bar2);
  }
}
```
### INTERFACE TO CLASS BINDING
- The best practice is having interface as the contract for us to then implement it in class
- Laravel handle this to bind interface and class together
- Interface to class type
	- bind(interface, class)
	- bind(interface, closure)
	- singleton(interface, class)
	- singleton(interface, closure
### CUSTOM SERVICE PROVIDER
- It is a provider of service and delivery
- We registrer the service and dependency inside this service provider
- There are many service providers that is inside the App/Provider folder
#### HOW TO CREATE A SERVICE PROVIDER
```bash php artisan make:provider [ServiceProviderName]``` - don't use the squared bracket
- In service provider there are 2 functions (main functions)
	- register()
		- register is to only register dependency into the container
		- don't register any thing beside the register, because the errors usually gives log that the dependency is not registered yet
	- boot()
		- boot is called after the all the dependency register finished
```php

    public function register()
    {
        $this->app->singleton(Foo::class, function($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

    }
```
- In analogy, register is when we fill the form of the registration, but we need to submit the registration form to make it active
	- The submission is in config app.php file
	- Go to providers then add into the Application Service Providers your registered service providers
```php
//app.php
...
'providers' => [
	...,
	App\Providers\YourServiceProviders::class
]
...
```
- Don't forget to clear and re cache the config in php artisan 
```bash
php artisan config:clear
php artisan config:cache
```
- It will be loaded when the laravel is first loaded
#### BINDING AND SINGLETON PROPERTIES
- For simple binding, for example interface-class binding
- Only for simple binding
```php
// YourServiceProvider.php
public array $singletons = [
    HelloService::class => HelloServiceEnglish::class
];
```
- I don't understand why the test not working and there are no singletons in the ServiceProvider root class
	- Solution: ```php artisan clear-compiled```
### DEFERRED PROVIDER
- On default providers are all loaded when laravel first loaded
- But we can choose on what provider that should be loaded with deferred provider and then we implement with method provides to give the information about what type of dependency that is inside the service provider
- It will make every service provider loaded only when it is used
- It is like lazy load
- The best use when the service providers are many
 ### FACADES
- Facades provides static access to the Service Container or Application
- It will be use when we code not in the scope of laravel codes
- Namespace: Illuminate/Support/Facades
- Use Dependency Injection as priority, don't use facades too frequent
- Helper functions means calling facades
- Testing will be easier when we are using facades
```php
//using facades
$firstName2 = Config::get('contoh.author.first');
$firstName3 = config("contoh.author.first");
// not using facades
$firstName = $config->get("contoh.author.first");
```
#### FACADES MOCK
- In Laravel there are facades mock that can be used for mock data
 ```php
 //example using mock
 Config::shouldReceive('get')
	->with("contoh.author.first")
	->andReturn("Mike Mozawski");
	//this won't get data that is inside the real config, only creates the mock one
```
### ROUTING
- Service Provider for routing: RouteServiceProvider
- It will execute route folder
- Route implementation that is easy is path and closure
```php
Route::get($uri,$callback);
//Change get with other method (post, put, patch, delete, options)
```
- unit test
```php
public function testBasicRouting()
{
	$this->get("/johntakpor")
		->assertStatus(200)
		->assertSeeText("Hello Johntakpor");
}
```
#### REDIRECT
```php
Route::redirect('/youtube', '/johntakpor')
```
- To see list use ```php artisan route:list ```
 #### FALLBACK ROUTE
- To return the error 404
```php
Route::fallback(function () {
	return 404;
})
``` 
### VIEW
- Using blade templating
- In app/resources/view
- Don't put logic in the blade view
- To get variable in blade template we could use ```{{ $ variableName }}```
- To render view, in routes, we must use ```Route::view(uri, template, array)``` or we can use closure view(template, array)
- Template is the name of the template that is not blade file, and array is filled with the variable data that we will use
```php
Route::view("/hello", "hello",  ["name" => "hello"]);

Route::get("/hello-again", function () {
    return view("hello", [ "name" => "Johnson"]);
});
```
- unit test is the same with assertSeeText
#### NESTED VIEW 
- Put the blade file in the folder inside the view folder (example: resources/view/nester/nested.blade.php)
- To accesss it, we don't use the slash (/) but use the dot ("nester.nested")
#### COMPILED VIEW
- View in laravel is compiled when the request goes in or when there are changes in the blade file
- But it will make the view loaded longer because of it
- It will be better especially in production for us to compile the view first
- The command is ``` php artisan view:cache ```
- It will make the load faster
- To remove the compiled file, we use ``` php artisan view:clear ```
#### TEST VIEW WITHOUT ROUTE
- We can test view without route
### STATIC FILE
- The first before the request get into the index.php, laravel will search for the url of the static file first
- Static file could be added in the public folder
- What is the use of css and js that is inside the resources folder
- It is for the compiled css and js so the size won't be too heavy
- To do the compilation: ``` npm run prod ```
### ROUTE PARAMETER
- Get data from the route parameter
- Naming consensus: route/{routeParam}
- How to get the routeParam: we can get it in closure function in route files
```php

Route::get("/products/{productId}", function ($productId){
    return "products : " . $productId;
});

Route::get("/products/{product}/items/{items}", function ($productId, $itemId){
    return "Products : " . $productId . ", Items : " . $itemId;
});
```
#### REGEX CONSTRAINTS
- using method where in Route::method function in route files
- Method where has 2 parameter
	- First is what parameter
	- Second is the regex
```php
Route::get('/categories/{id}', function (string $categoryId){
    return "Categories : " . $categoryId;
})->where("id" , '[0-9]+');
```
#### OPTIONAL PARAMETER
- Parameter is optional (not obliged)
- To make the parameter optional, we should be giving the question mark "?" in the parameter
- If parameter optional, then we should add the default value in the closure function
- The default will be shown in the returned value of the closure function\
```php
Route::get('/users/{id?}', function (string $userId){
    return "Users : " . $userId;
});
```
#### CONFLICTING PARAMETER
- Laravel will prioritize the first declared route 
- Laravel won't give any errors
```php

Route::get("/conflict/johntakpor", function(){
    return 'Conflict with Johntakpor';
});

Route::get("/conflict/{nameId}", function(string $nameId){
    return "Conflict " . $nameId;
});

```
- Unit Teset
```php

public function testConflict()
{
	$this->get('/conflict/budi')
		->assertSeeText("Conflict budi");

	$thi





