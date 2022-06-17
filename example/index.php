<?php
declare(strict_types=1);

use Elephox\Templar\Angle;
use Elephox\Templar\BoxShadow;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\Container;
use Elephox\Templar\Foundation\Expanded;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\Padding;
use Elephox\Templar\Foundation\Positioned;
use Elephox\Templar\Foundation\Row;
use Elephox\Templar\Foundation\Sizes;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\LinearGradient;
use Elephox\Templar\PositionContext;
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
						new Positioned(
							child: new Container(
								child: new Row(
									children: [
										new Text('Hello, world!'),
									],
									verticalAlignment: VerticalAlignment::Center,
								),
								color: Colors::SkyBlue(),
								shadows: [
									BoxShadow::fromElevation(8, color: Colors::Shadow()),
								],
								padding: EdgeInsets::symmetric(horizontal: Length::inPx(10)),
								height: Sizes::NavbarHeight(),
							),
							position: PositionContext::Fixed,
						),
						new Padding(
							child: new Column(
								children: [
									new Center(
										child: new Container(
											color: new LinearGradient(
												[
													Colors::SkyBlue(),
													Colors::HotPink(),
												],
												Angle::inDeg(165),
											),
											shadows: [
												BoxShadow::fromElevation(8),
											],
											margin: EdgeInsets::all(15),
											width: Length::inPx(150),
											height: Length::inPx(150),
										),
									),
									new Center(
										child: new Container(
											color: Colors::Red(),
											shadows: [
												BoxShadow::fromElevation(16),
											],
											margin: EdgeInsets::all(15),
											width: Length::inPx(150),
											height: Length::inPx(150),
										),
									),
									new Center(
										child: new Container(
											color: Colors::Green(),
											shadows: [
												BoxShadow::fromElevation(24),
											],
											margin: EdgeInsets::all(15),
											width: Length::inPx(150),
											height: Length::inPx(150),
										),
									),
									new Expanded(
										child: new Center(
											child: new Text('Hello, world!'),
										),
									),
									new Text('Hello, world!'),
								],
							),
							padding: EdgeInsets::all(Length::inRem(0.5))->add(
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
	$templar->render(new MyApp());
}
