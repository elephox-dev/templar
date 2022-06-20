<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\HashBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Elephox\Templar\HashBuilder
 * @covers \Elephox\Templar\Color
 */
class HashBuilderTest extends TestCase {
	public function hashEqualsValuesProvider(): iterable {
		yield [null, null];
		yield [false, false];
		yield [null, false];
		yield [true, true];
		yield [0, 0];
		yield [1, 1];
		yield [-1, -1];
		yield [0.0, 0.0];
		yield [1.0, 1.0];
		yield [-1.0, -1.0];
		yield ['', ''];
		yield ['a', 'a'];
		yield ['ab', 'ab'];
		yield [[0, 1, 2], [0, 1, 2]];
		yield [Colors::White(), Colors::White()];
	}

	/**
	 * @dataProvider hashEqualsValuesProvider
	 */
	public function testHashEquals(mixed $a, mixed $b): void {
		static::assertSame(
			HashBuilder::buildHash($a),
			HashBuilder::buildHash($b)
		);
	}

	public function hashNotEqualsValuesProvider(): iterable {
		yield [true, false];
		yield [1, 0];
		yield [Colors::White(), Colors::Black()];
		yield [1.1, 1.0];
	}

	/**
	 * @dataProvider hashNotEqualsValuesProvider
	 */
	public function testHashNotEquals(mixed $a, mixed $b): void {
		static::assertNotSame(
			HashBuilder::buildHash($a),
			HashBuilder::buildHash($b)
		);
	}

	public function testInvalidPart(): void {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(
			"Value of type '" . get_debug_type(new stdClass()) . "' cannot be hashed."
		);

		HashBuilder::buildHash(new stdClass());
	}
}