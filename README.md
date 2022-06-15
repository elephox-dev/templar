# Templar

Templar is a declarative templating engine for PHP. It was inspired by the approach used by [Flutter], written in [Dart].

## Basic Usage

```php
$templar = new Templar();
$template->render(new Homepage());

class Homepage extends Widget {
    public function build(BuildContext $context): Widget
    {
        return new Center(
            new Text('Hello, world!')
        );
    }
}
```

[Flutter]: https://flutter.dev/
[Dart]: https://dart.dev/
