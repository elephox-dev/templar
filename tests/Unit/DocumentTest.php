<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Foundation\Body;
use Elephox\Templar\Foundation\Document;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Templar;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\Foundation\Document
 * @covers \Elephox\Templar\Foundation\Head
 * @covers \Elephox\Templar\Foundation\Body
 * @covers \Elephox\Templar\Color
 * @covers \Elephox\Templar\ColorScheme
 * @covers \Elephox\Templar\Foundation\Colors
 * @covers \Elephox\Templar\HtmlRenderWidget
 * @covers \Elephox\Templar\Templar
 * @covers \Elephox\Templar\RenderContext
 * @covers \Elephox\Templar\Widget
 * @covers \Elephox\Templar\Foundation\Text
 * @covers \Elephox\Templar\HashBuilder
 * @covers \Elephox\Templar\TextStyle
 */
class DocumentTest extends TestCase {
	public function testHashCodeStaysTheSame(): void {
		$document = new Document(
			new Head(),
			new Body(new Text('Hello world!')),
		);

		$hash1 = $document->getHashCode();
		$hash2 = $document->getHashCode();

		$t = new Templar();
		$t->render($document);
		$t->renderStyle($document);

		$hash3 = $document->getHashCode();

		static::assertSame($hash1, $hash2);
		static::assertSame($hash2, $hash3);
	}
}