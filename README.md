# Templar

Templar is a declarative templating engine for PHP. It was inspired by the approach used by [Flutter], written in [Dart].

## Basic Usage

```php
class Homepage extends BuildWidget {
    public function build(): Widget
    {
        return new FullscreenDocument(
			      head: new Head(),
            body: new FullscreenBody(
                child: new Center(
                    new Text('Hello, world!'),
                ),
            ),
        );
    }
}

$templar = new Templar();
if (str_ends_with($_SERVER['REQUEST_URI'], '.css')) {
	header('Content-Type: text/css');

	echo $templar->renderStyle(new Homepage());
} else {
	header('Content-Type: text/html');

	echo $templar->render(new Homepage());
}

```

[Flutter]: https://flutter.dev/
[Dart]: https://dart.dev/
