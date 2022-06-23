<?php
declare(strict_types=1);

use Elephox\Templar\BackgroundImage;
use Elephox\Templar\Border;
use Elephox\Templar\BorderSide;
use Elephox\Templar\BoxFit;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\Foundation\App;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Container;
use Elephox\Templar\Foundation\Form;
use Elephox\Templar\Foundation\Image;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\NavigationBar;
use Elephox\Templar\Foundation\SubmitButton;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

require_once __DIR__ . '/../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(RenderContext $context): Widget {
		return new App(
			body: new Form(
				children: [
					new LinkButton(
						new Text("Visit elephox.dev"),
						"/",
					),
					new LinkButton(
						new Text("Visit elephox.dev"),
						"/",
						rank: ColorRank::Secondary,
					),
					new LinkButton(
						new Text("Visit elephox.dev"),
						"/",
						rank: ColorRank::Tertiary,
					),
					new Container(
						child: new Center(
							child: new Text("This is a container!"),
						),
						color: new BackgroundImage(
							src: "https://picsum.photos/200/300",
							fit: BoxFit::Cover,
						),
						padding: EdgeInsets::all(Length::inRem(2)),
						margin: EdgeInsets::symmetric(horizontal: Length::inRem(1)),
					),
					new Image(
						'https://picsum.photos/350/150',
						alt: 'Placeholder image',
						border: Border::all(BorderSide::ridge(3, Colors::LightGray())),
					),
					new SubmitButton(
						new Text("Submit"),
					),
				],
				direction: FlexDirection::Column,
				wrap: FlexWrap::Wrap,
				rowGap: Length::inRem(1),
				columnGap: Length::inRem(1),
			),
			title: "My App",
			navBar: new NavigationBar("My Awesome App"),
		);
	}
}

$templar = new Templar(
//	colorScheme: new ColorScheme(
//		primary: Colors::Red()->mix(Colors::Yellow(), 0.55)->lighten(0.1)->desaturate(0.2),
//		secondary: Colors::Green()->desaturate(0.2)->lighten(0.2),
//		tertiary: Colors::Azure()->lighten(0.1),
//	),
);
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
