<?php
declare(strict_types=1);

use Elephox\Templar\BoxShadow;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\Color;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Foundation\Center;
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
use Elephox\Templar\Length;
use Elephox\Templar\Templar;
use Elephox\Templar\TextStyle;
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
									$container = [];
									$count = 10;
									for ($i = 0; $i < $count; $i++) {
										$container[] = new Center(
											child: new Container(
												child: new Center(new Text((string) ($i * 4))),
												color: Color::fromRGBA(
													(int) (255 * $i / ($count - 1)),
													0,
													0,
													0xFF
												),
												shadows: [
													BoxShadow::ambient(),
													BoxShadow::fromElevation(4 * $i),
												],
												margin: EdgeInsets::symmetric(vertical: 8),
												width: 50,
												height: 50,
											),
										);
									}

									return new Column(
										children: $container,
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
	$templar->renderStyle(new MyApp());
} else {
	/** @noinspection PhpUnhandledExceptionInspection */
	$templar->render(new MyApp());
}
