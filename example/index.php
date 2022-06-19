<?php
declare(strict_types=1);

use Elephox\Templar\BoxShadow;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\Color;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\Container;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\LateWidget;
use Elephox\Templar\Foundation\NavigationBar;
use Elephox\Templar\Foundation\Padding;
use Elephox\Templar\Foundation\Sizes;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Foundation\Wrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\Templar;
use Elephox\Templar\TextStyle;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

require_once __DIR__ . '/../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(): Widget {
		return new FullscreenDocument(
			head: new Head(),
			body: new FullscreenBody(
				child: new Column(
					children: [
						new NavigationBar('My Awesome App'),
						new Padding(
							child: new LateWidget(
								function () {
									$containers = [];
									$count = 7;
									for ($i = 0; $i < $count; $i++) {
										$containers[] = new Center(
											child: new Container(
												child: new Center(new Text((string)($i * 4))),
												color: Colors::Gray(),
												shadows: BoxShadow::fromElevation(4 * $i)
													->withAmbient(),
												margin: EdgeInsets::all(8),
												width: 50,
												height: 50,
											),
										);
									}

									return new Column(
										children: [
											new Wrap(
												children: $containers,
												horizontalItemAlignment: HorizontalAlignment::Center,
												verticalAlignment: VerticalAlignment::Center,
											),
										],
									);
								}
							),
							padding: EdgeInsets::all(Length::inRem(1))->add(
								top: Sizes::NavbarHeight()
							),
						),
					],
				),
				textStyle: new TextStyle(
					font: 'sans-serif',
					size: Length::inRem(1),
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
if (str_ends_with(
	$_SERVER['REQUEST_URI'],
	'.css'
)) {
	header('Content-Type: text/css');

	echo $templar->renderStyle(new MyApp());
} else {
	header('Content-Type: text/html');

	/** @noinspection PhpUnhandledExceptionInspection */
	echo $templar->render(new MyApp());
}
