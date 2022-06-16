<?php
declare(strict_types=1);

use Elephox\Templar\Angle;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\Container;
use Elephox\Templar\Foundation\Expanded;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\SizedBox;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\LinearGradient;
use Elephox\Templar\Templar;
use Elephox\Templar\TextAlign;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

require_once __DIR__ . '/../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(): Widget {
		return new FullscreenDocument(
			head: new Head(),
			body: new FullscreenBody(
				child: new Center(
					child: new Column(
						children: [
							new Text('Hello, world!'),
							new SizedBox(
								child: new Container(
									child: new Text(
										'Hello, world!',
										align: TextAlign::Center,
									),
									//color: Color::lerp(0x0, Colors::Cyan, 0.5),
									color: new LinearGradient(
										[
											Colors::SkyBlue(),
											Colors::NeonPink(),
										],
										Angle::inDeg(165),
									),
								),
								width: Length::inPx(200),
								height: Length::inPx(200),
							),
							new Expanded(
								child: new Center(
									child: new Text('Hello, world!'),
								),
							),
							new Text('Hello, world!'),
						],
					),
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
	$templar->render(new MyApp());
}
