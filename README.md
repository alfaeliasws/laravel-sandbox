# Composer Installation
[[Fleeting Notes MOC]]
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
