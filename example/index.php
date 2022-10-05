<?php
declare(strict_types=1);

use Elephox\Templar\BootstrapIcon;
use Elephox\Templar\Border;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\BorderSide;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\FontAwesomeSolid;
use Elephox\Templar\Foundation\AppBar;
use Elephox\Templar\Foundation\AppLayout;
use Elephox\Templar\Foundation\Button;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Foundation\Container;
use Elephox\Templar\Foundation\Form;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\Hyperlink;
use Elephox\Templar\Foundation\Icon;
use Elephox\Templar\Foundation\LateTableCell;
use Elephox\Templar\Foundation\LateTableRow;
use Elephox\Templar\Foundation\Link;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\Row;
use Elephox\Templar\Foundation\Table;
use Elephox\Templar\Foundation\TableCell;
use Elephox\Templar\Foundation\TableRow;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Foundation\TextSpan;
use Elephox\Templar\Foundation\Title;
use Elephox\Templar\Length;
use Elephox\Templar\Octicon;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TableScope;
use Elephox\Templar\Templar;
use Elephox\Templar\TextDecoration;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

require_once __DIR__ . '/../vendor/autoload.php';

class MyApp extends BuildWidget {
	protected function build(RenderContext $context): Widget {
		return new AppLayout(
			body: new Form(
				children: [
					new LinkButton(
						new Text("Visit elephox.dev"),
						"https://elephox.dev",
						newWindow: true,
					),
					new LinkButton(
						new Text("Visit elephox.dev"),
						"https://elephox.dev",
						newWindow: true,
						rank: ColorRank::Secondary,
					),
					new LinkButton(
						new Text("Visit elephox.dev"),
						"https://elephox.dev",
						newWindow: true,
						rank: ColorRank::Tertiary,
					),
					new Table(
						rows: [
							new TableRow(
								cells: [
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
								},
							),
							new TableRow(
								cells: [
									new TableCell(
										new Text("Icons:"),
										isHeader: true,
										scope: TableScope::Row,
									),
									new TableCell(
										new Row(
											[
												new Icon(
													BootstrapIcon::bootstrapFill(),
													width: Length::inPx(24)
												),
												new Icon(
													FontAwesomeSolid::fontAwesome(),
													width: Length::inPx(24)
												),
												new Icon(
													Octicon::markGithub16(),
													width: Length::inPx(24)
												),
											],
											gap: Length::inPx(8),
										),
										colspan: 3,
									),
								],
							),
						],
						cellBorder: Border::symmetric(
							vertical: BorderSide::solid(1),
						),
					),
					new Button(
						new Text("Submit"),
					),
					new Container(
						child: new TextSpan(
							"I'm ",
							children: [
								new TextSpan(
									"important",
									style: new TextStyle(
										weight: 'bold',
										decoration: TextDecoration::underline(Colors::Red()),
									),
								),
								new TextSpan(" and "),
								new Hyperlink(
									"I'm a link",
									"#",
									visitedStyle: new TextStyle(color: Colors::Azure())
								),
							],
						),
						border: Border::all(
							BorderSide::dashed(
								1,
								Colors::Red()
							),
						),
						padding: EdgeInsets::all(5),
						borderRadius: BorderRadius::all(5),
					),
				],
				direction: FlexDirection::Column,
				wrap: FlexWrap::Wrap,
				rowGap: Length::inRem(1),
				columnGap: Length::inRem(1),
			),
			title: "My App",
			navBar: new AppBar("My Awesome App"),
			head: new Head(
				children: [
					new Title('I override the other title'),
					new Link('style.css'),
				],
			),
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
