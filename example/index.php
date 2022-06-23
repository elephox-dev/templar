<?php
declare(strict_types=1);

use Elephox\Templar\BuildWidget;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\Foundation\App;
use Elephox\Templar\Foundation\AppBar;
use Elephox\Templar\Foundation\Form;
use Elephox\Templar\Foundation\LateTableCell;
use Elephox\Templar\Foundation\LateTableRow;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\SubmitButton;
use Elephox\Templar\Foundation\Table;
use Elephox\Templar\Foundation\TableCell;
use Elephox\Templar\Foundation\TableRow;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TableScope;
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
						"https://elephox.dev",
						newWindow: true
					),
					new Table(
						rows: [
							new TableRow(
								[
									new TableCell(
										new Text("Current language:"),
										isHeader: true,
										scope: TableScope::Row,
									),
									new LateTableCell(
										function (RenderContext $context) {
											return new Text($context->meta->language);
										},
										colspan: 3,
									),
								],
							),
							new LateTableRow(
								function () {
									yield new TableCell(
										new Text("Generated cells:"),
										isHeader: true,
										scope: TableScope::Row,
									);

									for ($i = 0; $i < 3; $i++) {
										yield new TableCell(
											new Text("Cell $i"),
										);
									}
								}
							),
						],
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
			navBar: new AppBar("My Awesome App"),
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
