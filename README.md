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
- 