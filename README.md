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

	$this->get('/conflict/johntakpor')
		->assertSeeText("Conflict with Johntakpor");
}

```
### NAMED ROUTE
- We can name the route
- Naming route means we can use the name even though then we change the details of the route (url, closure, etc)
- We use function name()
```php

Route::get('/name/{id?}', function (string $id){
    return "Name " . $id;
})->name('user-name');

Route::get('/category-name/{id?}', function (string $id){
    return "Category Name " . $id;
})->name('category-name');
```
- How to use it
```php

Route::get('/user-search/{id}', function ($id){
    $link = route('user-name', [
        "id" => $id
    ]);
    return "Link " . $link;
});

Route::get('/user-search-redirect/{id}', function($id){
    return redirect()->route('user-name', [
        'id' => $id
    ]);
});
```
### CONTROLLER
- To make the app logic not in the route closure function, but in other space
- Controller is a class 
- Controller naming convention: YourController (change your with your desired name)
- Controller folder is in App/Http/Controller
- Use artisan to make it easier to create controller ```php artisan make:controller YourController```
- To change the closure in route we can make function in controller, then we integrate that function to the route
- To integrate with route, we use parameter array with controller and the function name
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function hello(): string
    {
        return "Hello World";
    }
}
```
Route Implementation:
```php
Route::get('/controller/hello', [HelloController::class, 'hello']);
```
Test
```php
    public function testHelloController()
    {
        $this->get("controller/hello")
            ->assertSeeText("Hello World");
    }
```
- Controller supports dependency injection
- Controller is made by Service Container, and it is stored withing service container
```php
<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use Illuminate\Http\Request;

class HelloController2 extends Controller
{
    private HelloService $helloService;

    public function  __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    public function hello(string $name): string
    {
        return $this->helloService->hello($name);;
    }
}
```
Route Implementation
```php
Route::get('/controller/hello2/{name}', [HelloController2::class, 'hello']);
```
### REQUEST
- Request is injected automatically to the controller class
- Use it inside the function and it will run smoothly
Implementation request on controller
```php

class HelloController3 extends Controller
{
    private HelloService $helloService;

    public function  __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    public function hello(Request $request,  string $name): string
    {
        return $this->helloService->hello($name);;
    }
}
```
- Request has many methods and many usecase especially about the url 
- Example:
	- Path
		- $request->path() to get the path from the url
		- $request->url() to get url without query parameters
		- $request->fullUrl() to get url with query parameters
	- Method
		- $request->method() to get HTTP method
		- $request->isMethod(method) to check if the method is right 
			- Example: $request->isMethod("post");
	- Header
		- $request->header(key) to get data header with key parameter
		- $request->header(key, default) get key with default value to be returned
		- request->bearerToken() it is used to get the information of token Bearer that is inside of Authorization header and automatically to delete the bearer prefix
Controller Function
```php

    public function request(Request $request): string
    {
        return $request->path() . PHP_EOL . 
            $request->url() . PHP_EOL . 
            $request->method() . PHP_EOL .
            $request->header("Accept") . PHP_EOL;
    }
}

```
Test
```php
   public function testRequest()
    {
        $this->get('controller/request', [
            "Accept" => "plain/text"
        ])->assertSeeText('controller/request')
            ->assertSeeText("http://localhost/controller/request")
            ->assertSeeText('GET')
            ->assertSeeText('plain/text')
        ;
    }
```
### REQUEST InPUT
- It doesn't matter from which method does the input comes from it can be get in laravel
- We can use input(key, default) in Request. It will return the default value if the key is not present
Controller Implementation
```php

class InputController extends Controller
{

    public function hello(Request $request): string 
    {
        $name = $request->input("name");
        return "Hello " . $name;
    }

}
```
Route
```php

Route::get('/input/hello', [InputController::class, 'hello']);

Route::post('/input/hello', [InputController::class, 'hello']);

```
Test
```php

    public function testInput()
    {
        $this->get('/input/hello?name=Johnson')->assertSeeText("Hello Johnson");
        $this->post('/input/hello', ["name" => "Johnson"])->assertSeeText("Hello Johnson");
    }

```
### NESTED INPUT
- We can take the nested data just by using the . (dot)
	- Example: $request->input('name.first')
		- It is when the input is in the form of form or json
Controller Function
```php
    public function helloFirst(Request $request): string
    {
        $firstName = $request->input("name.first");
        return "Hello " . $firstName;
    }
```
Test
```php
    public function testInputNested()
    {
        $this->post('/input/hello/first', ["name" => [
            "first" => "Johnson",
            "last" => "Songkali"
        ]])->assertSeeText("Hello Johnson");
    }
```
#### REQUEST PAGE EXPIRED
- If there are PAGE EXPIRED error when we unit test we can use php artisan cache:clear and php artisan config:clear
- If we use postman or any other services it will return PAGE EXPIRED
	- It is because it is secured by the laravel
	- We can turn it off first in Http/Kernel
		- Then we can comment the Middleware/VerifyCsrfToken::class
#### GET ALL INPUTS
- Use input() method
Controller
```php

    public function helloInput(Request $request): string
    {
        $input = $request->input();
        return json_encode($input);
    }

```
Test
```php
    public function testInputGetAll()
    {
        $this->post('/input/hello/input', ["name" => [
            "first" => "Johnson",
            "last" => "Songkali"
        ]])->assertSeeText("name")->assertSeeText("first")->assertSeeText("Johnson")->assertSeeText("last")->assertSeeText("Songkali");
    }
```
#### GET ARRAY INPUT
- Get input value array
	- We can use `$request->input('products.*.name')`, in that case we get all the name in array of products
Controller
```php
    public function helloArray(Request $request): string
    {
        $names = $request->input('products.*.name');
        return json_encode($names);
    }
```
Test
```php
    public function testInputArray()
    {
        $this->post('/input/hello/array', ["products" => [
            [
                "name" => "Apple Mac Book Pro",
                "price" => "20000000"
            ],
            [
                "name" => "Samsung Galaxy S",
                "price" => "18000000"
            ]
        ]])->assertSeeText("Apple Mac Book Pro")->assertSeeText("Samsung Galaxy S");
    } 
```
#### INPUT QUERY
- If we want to get only the data in query parameters then we should use `$request->query(key)`
	- If we want to get all the data that is in query parameters then we should use `request->query()`
#### DYNAMIC PROPERTY
- If we use `$request->first_name` (equals `$request->input($first_name)`) then laravel will check if the request has a key that is first_name
- It is more applicable to use input more than to use dynamic property
### INPUT TYPE
- Request object have features that makes the conversion of data type automatically
- To make input type to boolean we can use `boolean(key, default)`
- To make input type to date automatically we can use `date(key, pattern, timezone)`
	- Laravel use Carbon library to manipulate the date type
Controller
```php

    public function inputType(Request $request): string 
    {
        $name = $request->input('name');
        $married = $request->input('married');
        $birthDate = $request->input('birth_date', 'Y-m-d');

        return json_encode([
            "name" => $name,
            "married" =>  $married,
            "birthDate" => $birthDate->formate('Y-m-d')
        ]);
    }
```
#### FILTER REQUEsT INPUT
- It is to prevent the code to execute key (js equivalent of property) that is not intended to be changed
- There are methods in input request to choose and do exceptions of the keys that will be proceeded to the DB
	- `$request->only([key1,key2])`
	- `$request->except([key1,key2])`
Controller
```php

    public function filterOnly(Request $request): string
    {
        $name = $request->only(['name.first', 'name.last']);
        return json_encode($name);
    }

    public function filterExcept(Request $request): string
    {
        $user = $request->except(["admin"]);
        return json_encode($user);
    }
```
Test
```php

    public function testFilterOnly()
    {
        $this->post('input/filter-only', [
            "name" => [
                "first" =>  "Johntakpor",
                "middle" => "Johnson",
                "last" => "Songkali"
            ]
        ])->assertSeeText("Johntakpor")->assertSeeText("Songkali")->assertDontSeeText("Johnson");
    }

    public function testFilterExcept()
    {
        $this->post('input/filter-except', [
            "username" => "Johnson",
            "admin" => "true",
            "password" => "rahasia" 
        ])->assertSeeText("Johnson")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }
```
#### MERGE INPUT
- We want to have default input value when the input is not inserted from the request, then we can use merge to add the input to the request
- If there are the same key, it will be changed with the merge one using `merge(array)`
- If there are the same key but we want to make the key from the request sustained we can use mergeIfMissing(array)
Controller
```php
    public function testMerge()
    {
        $this->post('input/filter-merge', [
            "username" => "Johnson",
            "admin" => "true",
            "password" => "rahasia" 
        ])->assertSeeText("Johnson")->assertSeeText("rahasia")->assertSeeText("admin")->assertSeeText("false");
    }
```
### FILE STORAGE
- Laravel is using file storage of flysystem
- We can save file to the file storage or change the target of the file storage itself
	- It could be our own local storage or to amazon s3
- Configuration in file storage exists in file config/filesystems.php
	- We can modify the configuration of the file storage there (which file storage, etc)
	- The default is local
	- On the disks array are the type of the storage (local, public, s3)
	- In links we can use our own "naming" using links and abstract the path that we want to use with that link
- The implementation is using class taht is named FileSystem
- To get the storage, we can use the Facade of `Storage::disk(fileStorageName)`
Test
```php

    public function testStorage()
    {
        $filesystem = Storage::disk("local");
        $filesystem->put("file.txt", "Put Your Control Here");

        self::assertEquals("Put Your Control Here", $filesystem->get("file.txt"));
    }
```
#### STORAGE LINK
- By default, the file in storage/app can't be accessed
- Laravel has Storage Link that link the storage/app/pubic to public/storage, so we can access the File Storage from the web/client
- To make link we can use the command `php artisan storage:link`
```php

    public function testPublic()
    {
        $filesystem = Storage::disk("public");
        $filesystem->put("file.txt", "Put Your Control Here");

        self::assertEquals("Put Your Control Here", $filesystem->get("file.txt"));
    }
```
### FILE UPLOAD
- Laravel have method of file(key) in Request body to handle the file upload
- File Upload data type is in the class of Illuminate\Http\UploadedFile in Laravel
- File Upload in Laravel is integrated with File Storage
- Method storePubliclyAs means we use the public type of the request store and the public of the last parameters eans we use public that is defined in file config
- The first parameters of "pictures" means we want it in the folder named pictures
Controller
```php
    public function upload(Request $request): string
    {
        $picture = $request->file("picture");
        $picture->storePubliclyAs("pictures", $picture->getClientOriginalName(), "public");

        return "OK " . $picture->getClientOriginalName();
    }
```
ERROR: Error: Call to undefined function Illuminate\Http\Testing\imagecreatetruecolor()
SOLUTION: extention gd in php.ini to be enabled
Test
```php
    public function testUpload()
    {
        $image = UploadedFile::fake()->image("johnson.png");
        $this->post('file/upload', [
            "picture" => $image
        ])->assertSeeText("OK : johnson.png");
    }
```
### RESPONSe
- We can return response too in laravel and there it is, the response object
- In response class, we can modify HTTP Response of Body, Header, Cooke, etc
- To create response object, we can use helper function of `response(content, status, headers)`
Controller
```php
    public function response(Request $request): Response
    {
        return response("Hello Response");
    }
```
Test
```php
    public function testResponse()
    {
        $this->get('response/hello')
            ->assertStatus(200)
            ->assertSeeText("Hello Response");
    }
```
#### REsPONSE HEADER
- We can use the default building response method (`response(content, status, headers)`) 
- Or using the `withHeaders(arrayHeaders)` method to add headers
- Or using `headers(key,value)`
#### RESPONSE TYPE
- To have view we can use the view method `view(name, data, status, header)`
- To have response json we can use the `json(array,status,headers)`
- To have response file we can use the `file(pathToFile,headers)`
- To have response of download we can use the `download(pathToFile, name, headers)`
Controller
```php
    
    public function responseView(Request $request): Response
    {
        return response()
            ->view('hello', ['name' => 'Johnson']);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = ['firstName' => 'Johntakpor', 'lastName' => 'Songkali'];
        return response()->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/johnson.png'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/johnson.png'), 'johnson.png');
    }
```
Test
```php
	
    public function testView()
    {
        $this->get('response/type/view')
        ->assertSeeText('Hello Johnson');
    }


    public function testJson()
    {
        $this->get('response/type/json')
        ->assertJson(
            ['firstName' => 'Johntakpor', 'lastName' => 'Songkali']
        );
    }

    public function testFile()
    {
        $this->get('response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload()
    {
        $this->get('response/type/download')
            ->assertDownload('johnson.png');
    }
```
### ENCRYPTION
- Encryption should not be done manually or with other libraries
- To encrypt, laravel needs keys
- The key is saved in config/app.php
- Laravel will get the key from environment APP_KEY
- Update APP_KEY in .env in frequency
- To update APP_KEY for encryption we could use `php artisan key:generate`
- To do encrypt and decrypt we could use Facade class Crypt
```php
public function testEncryption()
    {
        $encrypt = Crypt::encrypt('Johntakpor Songkali');
        $decrypt = Crypt::decrypt($encrypt);

        self::assertEquals('Johntakpor Songkali', $decrypt);
    }
```
### COOKIE
- Cookie will be encrypted automatically
- The encryption is located in App/Http/Middleware/EncryptCookies
- We can modify the EncryptCookie property (except variable)
- To create cookie we can use method `$cookie(name, value, timeout, path, domain, secure, httpOnly)` in Response object
Controller
```php

    public function createCookie(): Response
    {
        return response('Hello Cookie')
            ->cookie('User-Id', 'johntakpor', 1000, '/')
            ->cookie('Is-Member', 'true', 1000, '/');
    }

```
Test
```php

    public function testCreateCookie()
    {
        $this->get('cookies/set')
            ->assertCookie('User-Id', 'jontakpor')
            ->assertCookie('Is-Member', 'true');
    }

```
#### RECEIVE COOKIE
- After the cookie is given to the browser, browser will keep that cookie, until it is expired or timeout
- Browser will send the request of renewing the cookie to the path that is set when creating cookie
- We can get the cookie in request using `cookie(name, default)`
- Or to get all cookies from array, we can use `$request->cookies->all()`
- To receive cookie
Controller
```php

    public function getCookie(Request $request): JsonResponse
    {
        return response()
            ->json(
                [
                    'userId' => $request->cookie('User-Id', 'guest'),
                    'isMember' => $request->cookie('Is-Member', 'false')
                ]
            );
    }
```
Test
```php
    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'johntakpor')
            ->withCookie('Is-Member', 'true')
            ->get('cookies/get')
            ->assertJson([
                'userId' => 'johntakpor',
                'isMember' => 'true'
            ]);
    }
```
#### CLEAR COOKIE
- There is no way to delete cookies
- But we can make the cookie to have empty values and use he timeout as soon as possible
- We can use the laravel method withoutCookie(), it makes the cookie expired and make the cookie not present from the cookie developer mode in browser
Controller
```php

    public function clearCookie(Request $request): Response
    {
        return response('Clear Cookie')
            ->withoutCookie('User-Id')
            ->withoutCookie('Is-Member');
    }

```
### REDIRECT
- We can use `redirect(to)`
Controller
```php

    public function redirectTo(): string
    {
        return "Redirect To";
    }

    public function redirectFrom(): RedirectResponse
    {
        return redirect('/redirect/to');
    }
```
Test
```php

    public function testRedirect()
    {
        $this->get('/redirect/from')
            ->assertRedirect('/redirect/to');
    }
```
#### REDIRECT TO NAMED ROUTES
- We can redirect to the route's name not to the actual route itself
- It will make everything easy when there are changes in the actual route
- We can use `route(name, params)` in RedirectResponse
Controller
```php

    public function redirectName(): RedirectResponse
    {
        return redirect()->route('redirect-hello', ['name' => 'John',]);
    }

    public function redirectHello(string $name): string
    {
        return "Hello $name";
    }

```
Route
```php
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);

Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name("redirect-hello");
```
Test
```php
    public function testRedirectName()
    {
        $this->get('/redirect/name')
            ->assertRedirect('/redirect/hello/John');
    }
```
#### REdIRECT TO CONTROLLER ACTIOn
- `action(controller, params)` in RedirectResponse
Controller
```php
    public function redirectAction(): RedirectResponse
    {
        return redirect()->action([RedirectController::class, 'redirectHello'], ['name' => 'John']);
    }
```
Test
```php
    public function testRedirectAction()
    {
        $this->get('/redirect/action')
            ->assertRedirect('/redirect/name/John');
    }
```
#### REDIRECT TO EXTERNAL DOMAIN
- Laravel can only redirect to the same domain
- If we want it to redirect to the other domain we should use `away(url)` in RedirectResponse
```php
//Controller

    public function redirectAway(): RedirectResponse
    {
        return redirect()->away('https://alfaeliasws.netlify.app/');
    }

// Test

    public function testRedirectAway()
    {
        $this->get('/redirect/away')
            ->assertRedirect('https://alfaeliasws.netlify.app/');
    }
```
### MIDDLEWARE
- To do filtering of HTTP Request that is getting in 
- Laravel use so many middleware, for example are cookie encryption, verification, CSRF, authentication
- All middleware are saved in app/Http/Middleware
- We can use multiple middleware
- We can create middleware and we can use `php artisan make:middleware MiddlewareName`
- Middleware is in the scope of dependency injection so we can use the dependency that we wants in the constructor if we wants it
- Middleware is a simple class and only have method `handle(request, closure)` that will be called before it goes to the controller
	- If we want to send it to the controller, we can use the closure parameter
	- Or we can manipulate anything in the controller
- Method `handle()` in middleware can return a response
```php
	//Middleware
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        if($apiKey == "John"){
            return $next($request);
        } else {
            return response('Access Denied', 401);
        }
    }
```
#### GLOBAL MIDDLEWARE
- Middleware won't be executed by Laravel, we should register it to our apps
- We can register it in many ways
- First is when we want to register it as global middleware
- Global means the middleware will get to be executed in every routes, we can register it in field `$middleware` in Http kernel
```php
//Http Kernel
    protected $middleware = [
        'example' => ExampleMiddleware::class
```
####  ROUTE MIDDLEWARE
- We can assign middleware to the routes too, we can employ the middleware to the routes in groups or one by one
- To registrate one by one we can use the middleware class directly or using the `$routeMiddleware` in Kernel class
```php
//Http Kernel
    protected $routeMiddleware = [
        'example' => ExampleMiddleware::class
``` 
- How to use middleware in routes after it is registered in kernel
```php
//web.php
//Using alias
Route::get('/middleware/api', function(){return "OK";})->middleware(['example']);

//Not using alias
Route::get('/middleware/api', function(){return "OK";})->middleware([ExampleMiddleware::class]);
```
#### GROUP MIDDLEWARE
- We can make a middleware in groups also, so when we want to use it, we only mention the name
- We can use the middleware groups in kernel file `$middlewareGroups` 
```php
    protected $middlewareGroups = [
        'john' => [
            ExampleMiddleware::class
        ]
```
- The group can be used in RouteServiceProviders.php in boot function and define in which prefix does it start
- To use in route file we can use it to be like this
```php
//Route
Route::get('/middleware/group', function(){return "GROUP";})->middleware(['john']);

//Test

    public function testInvalidMiddlewareGroup()
    {
        $this->get('middleware/group')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddlewareGroup()
    {
        $this->withHeader('X-API-KEY', 'John')
            ->get('middleware/group')
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }
```
#### MIDDLEWARE PARAMETER
- We can do dependency injection in middleware, but we can inject a simple parameter
- Just use the `handle()` method, and add it after the `$next` parameter, and we can call the parameter by calling the middleware with `:`
- If there are more than one parameter, use `,` 
```php
//Middlewawre method
    public function handle(Request $request, Closure $next, string $key, int $status ){
        $apiKey = $request->header('X-API-KEY');
        if($apiKey == $key){
            return $next($request);
        } else {
            return response('Access Denied', $status);
        }
    }
//Route web.php
Route::get('/middleware/group2', function(){return "GROUP";})->middleware(['param:john,401']);

///Kernel

     protected $middlewareGroups = [
        'john' => [
            ExampleMiddleware::class
        ],
        'param' => [
            'param:john,401'
        ],

// ...

// Kernel
    protected $routeMiddleware = [
        'param' => ExampleParamMiddleware::class,

//Test
    public function testInvalidMiddlewareGroupParam()
    {
        $this->get('middleware/group2')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddlewareGroupParam()
    {
        $this->withHeader('X-API-KEY', 'john')
            ->get('middleware/group2')
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }
    //make sure that the header is the same as the parameter in kernel middlewareGroup and in route web.php

```
#### EXCLUDE MIDDLEWARE
- If we want our route to run without middleware, we can use `withoutMiddleware()`
```php
Route::post('/file/upload/without', [FileController::class, 'upload' ])->withoutMiddleware([VerifyCsrfToken::class]);
```
### CSRF (CROSS SITE REQUEST FORGERY)
- To make our domain accept request from other domains
- To handle it is to make the request to have token, if it is valid, it can continue to have the access, if it isn't, it won't make our site couldn't be accessed
- To create the token, laravel itself have the function of `csrf_token()`
- Everytime we access a laravel website, it will run session that will save the csrf token
- If we want to do post request, we should include it in our input
- Laravel will check the input _token
```blade.php
// _
<html>
  <head>
    <title>Say Hi</title>
    <body>
      <form action="/form" method="post">
        <label for="name">
          <input type="text" name="name">
        </label>
        <input type="submit" value="Say Hello">
        <input type="hidden" value="_token" value={{csrf_token()}}>
      </form>
    </body>
  </head>
</html>
```
- In Ajax, just send the token using X-CSRF-TOKEN in header
### ROUTE GROUP
- We can group route to share the configuration across route inside that one group
- It is easier than when we configure the route one by one
- We can use the route prefix, so we can make route that having a same prefix easier
- We can use function `Route::prefix(prefix)->group(closure)`
```php
Route::prefix('/response/type')->group(function(){
    Route::get('/view', [ResponseController::class, 'responseView' ]);
    Route::get('/json', [ResponseController::class, 'responseJson' ]);
    Route::get('/file', [ResponseController::class, 'responseFile' ]);
    Route::get('/download', [ResponseController::class, 'responseDownload' ]);
});
```
### ROUTE MIDDLEWARE GROUP
- We can group that is using the same middleware
```php
//web.php route
Route::middleware(['param:john,401'])->group(function(){
    Route::get('/middleware/group2', function(){ return "OK";});
	// ... other functions
});
```
### ROUTE CONTROLLER GROUP
- We can group route that is using the same controller
```php
Route::controller(CookieController::class)->group(
    function(){
        Route::get('/coookies/set', 'createCookie');
        Route::get('/coookies/get', 'getCookie');
        Route::get('/coookies/clear', 'clearCookie');
    }
);
```
### ROUTE MULTIPLE GROUp
- To do multiple of grouping
```php
// web.php route
Route::middleware(['param:john,401'])->prefix('/middleware')->group(function () {
    Route::get('/api3', function () {
        return "OK";
    });
});

// test
    public function testInvalidMiddlewareGroupRoute()
    {
        $this->get('middleware/api3')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddleGroupRoute()
    {
        $this->withHeader('X-API-KEY', 'john')
            ->get('middleware/api3')
            ->assertStatus(200)
            ->assertSeeText("OK");
    }
```
### URL GENERATION
- To create URL or link that can be used in view and response
#### CURRENT URL
- We can access current url in request object but there are times where there is no object request
- We can use url helper or facade url
- `url()->current()` for current url without query param
- `url()->full()` for full url with query param
```php
//web.php route
Route::get('/url/current', function(){return URL::full();});

// test
public function testCurrent()
{
	$this->get('/url/current?name=John')
		->assertSeeText('/url/current?name=John');
}

```
#### Named Routes
- It can be used to create link from named routes
- We can use route 
	- `route(name, parameters)`
	- `URL::route(name, parameters)`
	- `url()->route(name, parameters)`
```php
//web.php route
Route::get('/url/named', function(){return route('redirect-hello', ['name' => 'Justin']);});

//test
    public function testNamed()
    {
        $this->get('url/named')->assertSeeText('/redirect/name/Justin');
    }
```
#### URL FOR CONTROLLER ACTION
- Url generation can be used to create link to the controller action
- We can use method of 
	- `action(controllerAction, parameters)`
	- `URL::action(controllerAction, parameters)`
	- `url()->action(controllerAction, parameters)`
```php
// web.php route
Route::get('/url/action', function(){    
    return URL::action([FormViewController::class, 'form'], []);
    // return url()->action([FormViewController::class, 'form'], []);
    // return action([FormViewController::class, 'form'], []);
});

// test
    public function testAction()
    {
        $this->get('url/action')->assertSeeText('/form');
    }
``` 
### SESSION
- Session is independent and because of Http is stateless, it won't get with any other request
- Session is used to save data that is used by other requests, usually the store is stored inside the persistent storage
- Laravel give abstraction layer for us to manage session, so there should be not using PHP session anymore
- All configuration is in `config/session.php`
	- Important in that file
		- SESSION_DRIVER (default to where to store the session), it is stored in env with the same SESSION_DRIVER
			- File: session will be saved in storage/framework/sessions
			- Cookie: session will be stored in cookie with encryption
			- Database: session will be stored in database
			- Memcache/redis : session will be stored in the memory database
			- Dynamodb: Session is stored in amazon dynamodb
			- Array: session is stored in memory array
		- SESSION_LIFETIME
		- files: path of where the session will be stored in
		- etc
- Session is represented in interface Illuminate/Contracts/Session/Session
- To get session we can use
	- method `session` from request object
	- helper method `session()`
	- Facade `Session`
- Method to manipulate data in session
	- `put(key, value)` : save data with key and value
	- `push(key, value)` : add data to the array of key value
	- `pull(key, value)` : get data and delete the  data
	- `increment(key, value)` : add value in session
	- `decrement(key, value)` : decrease value in session
	- `forget(key, value)` : delete a data in session
	- `fluseh(key, value)` : delete all data in session
	- `invalidate(key, value)`: delete all data and delete the session, then creating new empty session
```php
//controller

  public function createSession(Request $request): string
  {
    $request->session()->put('userId', 'johntakpor');
    $request->session()->put('isMember', 'true');

    return "OK";
  }

//test
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText("OK")
            ->assertSessionHas("userId", "johntakpor")
            ->assertSessionHas("isMember", "true");
    }
```
- Get data in session
	- `get(key, default)` : to get the value of stored key in session
	- `all(key, default)` : to get all the data in the session
	- `has(key)` : to check the data in session
	- `missing(key)` : to check if the data is not present in the session
	

```php
//controller
  public function getSession(Request $request): string
  {

    $userId = $request->session()->get('userId', 'guest');
    $isMember = $request->session()->get('isMember', 'false');

    return "User Id : $userId, Is Member: $isMember";
  }

//test

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'johntakpor',
            'isMember' => 'true',
        ])->get('/session/get')
        ->assertSeeText("johntakpor")->assertSeeText("true");
    }
    
    public function testGetSessionFalse()
    {
        
        $this->withSession([])->get('/session/get')
        ->assertSeeText("guest")->assertSeeText("false");
    }

```





