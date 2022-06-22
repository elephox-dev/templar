<?php
declare(strict_types=1);

use Elephox\Templar\BuildWidget;
use Elephox\Templar\ColorRank;
use Elephox\Templar\ColorScheme;
use Elephox\Templar\Foundation\App;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\NavigationBar;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

require_once __DIR__ . '/../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(RenderContext $context): Widget {
		return new App(
			body: new Column(
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
				],
				gap: Length::inRem(1),
			),
			title: "My App",
			navBar: new NavigationBar("My Awesome App"),
		);
	}
}

$templar = new Templar(
	colorScheme: new ColorScheme(
		primary: Colors::Red()->mix(Colors::Yellow(), 0.55),
	),
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
