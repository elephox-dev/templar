<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Integration;

use Elephox\Templar\Foundation\Body;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\Document;
use Elephox\Templar\Foundation\Expanded;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\LateWidget;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

it(
	'doesnt modify the hash code when rendered',
	function () {
		$document = new Document(
			new Head(),
			new Body(
				new Column(
					children: [
						new Expanded(
							new Center(
								new Text('Hello world!'),
							),
						),
					],
				),
				textStyle: new TextStyle(
					font: 'sans-serif',
					size: Length::inRem(1),
				),
			),
		);

		$hash1 = $document->getHashCode();

		$t = new Templar();
		$t->render($document);
		$t->renderStyle($document);

		$hash2 = $document->getHashCode();

		$this->assertSame(
			$hash1,
			$hash2
		);
	}
);

it(
	'doesnt modify the hash code while being rendered',
	function () {
		$snapshotHash1 = null;

		$document = new Document(
			new Head(),
			new Body(
				new LateWidget(
					function (RenderContext $context, Widget $parent) use (&$snapshotHash1) {
						$snapshotHash1 = $parent->renderParent->renderParent->getHashCode();

						return new Text("test");
					}
				),
				textStyle: new TextStyle(
					font: 'sans-serif',
					size: Length::inRem(1),
				),
			),
		);

		$hash1 = $document->getHashCode();

		$t = new Templar();
		$t->render($document);
		$t->renderStyle($document);

		$hash2 = $document->getHashCode();

		$this->assertSame(
			$hash1,
			$hash2
		);
		$this->assertSame(
			$snapshotHash1,
			$hash1
		);
	}
);

it(
	'has the correct hash code in the stylesheet',
	function () {
		$body =
			new Text(
				'Hello world!',
				style: new TextStyle(font: "monospace")
			);

		$hash = $body->getHashCode();

		$t = new Templar();
		$structure = $t->render($body);
		$style = $t->renderStyle($body);

		$this->assertStringContainsString(
			sprintf(
				'class="elephox-templar-foundation-text-%.0f"',
				$hash
			),
			$structure,
		);

		$this->assertStringContainsString(
			sprintf(
				'.elephox-templar-foundation-text-%.0f {',
				$hash
			),
			$style
		);
	}
);