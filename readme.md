# Glasses

Simple text parsing. For php.

## Installation

Installation is easy. Simply `require` or `include` the `glasses.php` file into your project.

## Usage

Usage is easy. There are three steps.

1. Call `new Glasses()` and assign it to a variable.
2. Add rules.
3. Parse

```php
require 'vendor/Glasses/glasses.php';

$parser = new Glasses();
$parser->rule('welcome', 'hello world', 'Welcome');
$parser->parse('hello world'); // Welcome->to();
$parser->parse('silly people'); // nil
```

###Rules
Rules are the things that Glasses searches for in your text. They check against a modified `regex`.

The `->rule()` function takes three parameters.

```php
function rule($name, $test, $class)

(string) $name : The name of the rule.
(string) $test : The modified regex or text to search for.
(string | array) $class : The name of a class or an array of class name and method name.
```

####Wildcards
Wildcards can be used in the second argument of the `->rule()` function (the modified regex).

```php
$parser->rule('username', '@(:any)', 'Users');
```
The wildcard is the `(:any)` which is the only default wildcard. How wildcards work, is that they are replace by a regex.

The default wildcards are:

```
{
	':any' : '[0-9a-zA-Z~%\.:_\\-]+'
}
```
You can change the defaults by calling the `->set_wildcards()` method ([more below](#config)).

What happens is instead of using `@(:any)` as the modified regex, it replaces `:any` with `[0-9a-zA-Z~%\.:_\\-]+`, so the modified regex is: `@([0-9a-zA-Z~%\.:_\\-]+)`.

###Parsing

To parse text, you must call the `->parse()` function. It accepts one argument, the text.

```php
function parse($text)

(string) $text : The text to parse
```

How parsing works, is that it loops through each rule and uses the `preg_match_all` function to see if any of the rules match the text. If so, then it [builds](#building). You can have multiple matches for each rule and multiple rules can return true.

###Building

Once a match is found between a rule and text, it does one of two things: if the `$class` argument in the rule that is matched is a string, then it creates a new instance of that class and calls the [default method](#config). The other is if the `$class` argument is an array if that is so, The class name is the first string, and the method is the second string.

---
Example of option 1:

```php
$parser->rule('welcome', 'hello world', 'Welcome');
$parser->parse('hello world'); // Welcome->to();
```

---
Example of option 2:

```php
$parser->rule('welcome', 'hello world', array('Messages', 'welcome'));
$parser->parse('hello world'); // Messages->welcome();
```

When the method is called it passes one argument, the build (an object).

Here is an example of a build:

```php
stdClass Object
(
    [str] => hello world
    [test] => hello world
    [regex] => /hello world/
    [matches] => Array
        (
            [0] => stdClass Object
                (
                    [name] => 
                    [text] => hello world
                )

        )

)
```

Here is another example with wildcards:

```php
stdClass Object
(
    [str] => @username
    [test] => @(:any)
    [regex] => /@([0-9a-zA-Z~%\.:_\-]+)/
    [matches] => Array
        (
            [0] => stdClass Object
                (
                    [name] => username
                    [text] => @username
                )

        )

)
```

###Config

There are two configuration methods: `set_method`, and `set_wildcards`.

---

```php
function set_method($method)

(string) $method : The default method if there is not one provided.
```

The default method is `to`.

---

```php
function set_wildcards($wildcards)

(array) $wildcards : The array of wildcards used in parsing.
```
The default wildcards are :

```
{
	':any' : '[0-9a-zA-Z~%\.:_\\-]+'
}
```
