<?php
declare(strict_types=1);

use Elephox\Templar\BuildWidget;
use Elephox\Templar\Foundation\Body;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Document;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

require_once '../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(): Widget {
		return new Document(
			new Head(
				title: 'My App',
			),
			new Body(
				child: new Center(
					child: new Text('Hello, world!'),
				),
			),
		);
	}
}

$templar = new Templar();
$templar->render(new MyApp());
