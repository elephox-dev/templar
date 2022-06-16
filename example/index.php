<?php
declare(strict_types=1);

use Elephox\Templar\BuildWidget;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

require_once '../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(): Widget {
		return new FullscreenDocument(
			head: new Head(),
			body: new FullscreenBody(
				child: new Center(
					child: new Text('Hello, world!'),
				),
			),
			documentMeta: new DocumentMeta(
				title: 'My App',
				language: 'en-US',
			),
		);
	}
}

$templar = new Templar();
$templar->render(new MyApp());
