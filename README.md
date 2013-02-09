# SxPhandbox

## Introduction
This is a php sandbox application. Just run it, and and start writing php.

## Features
* Error reporting
* Syntax checking
* Runtime error reporting
* "Live" code execution
* Save snippets
* Load snippets

## Installation/Usage
Just clone this repository to.. Well, anywhere. Then, find out what [Composer](http://getcomposer.org/) is. Get it. Install it. Then run the following:
`composer install`
Done? Good. Now, make sure that `data/snippets` is writable. chmod it to 777, set the user permissions, I don't care. 

Now the super duper complicated part, _running the application_. `php public/index.php`. Ok, not THAT complicated. Anyway, the rest is in your console output.

Have fun :D

## Disclaimer
This application is not safe, at all. I'm not checking for filenames, I'm not validating php code and I'm not validating input in any other way.
I've tested this application in google chrome, on an iMac.

The code is not all that exciting, I've kept it very simple. There are no docblocks.

Still, I think that this is a useful tool, as long as you don't try to hack your own development machine. (Which would be silly).

PR's are welcome if you've improved upon this tool.
