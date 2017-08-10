# loader

Entry point for your core-php application

Now Entry point of your application would look something like this
##### index.php
```php
namespace app {

    use \bootphp\loader\Loader;
    use \bootphp\fn;

    include_once "lib/autoload.php";

    class Index extends Loader
    {
        public $title = "DEFAULT_TITLE";

        public function __construct()
        {
            // TODO: Something you want to do before I do something.
            fn::println("__construct");
            fn::println("Title in query is " . $this->title);
            fn::println("Title2 in query is " . $this->title2);
            fn::println("Title3 in query is " . $this->title3);
        }

        public function invoke($options)
        {
            // TODO: What you want to do?.
            // You can access all Query params here as instance properties like : $this->title
            fn::println("invoke");
            fn::println("Title in query is " . $this->title);
            fn::println("Title2 in query is " . $this->title2);
            fn::println("Title3 in query is " . $this->title3);
        }

        public function __destruct()
        {   
            // Now evrything is done.
            // TODO: Something you want to do before i say goodbye.
        }

    }

    (new Index)();
    //OR (new Index())->execute();
}
```
Try this url with different values or no values

```bash
    http://localhost/index.php?title=lucas&title2=no&title3=yes

```
