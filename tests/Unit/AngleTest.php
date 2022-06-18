<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Angle;
use Elephox\Templar\AngleUnit;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Templar\Angle
 * @covers \Elephox\Templar\AngleUnit
 */
class AngleTest extends TestCase {
	public function testIn(): void {
		$a = Angle::inDeg(90);
		static::assertSame(AngleUnit::Deg, $a->unit());
		static::assertSame(90.0, $a->value());
		static::assertSame(2, $a->precision());

		$b = Angle::inRad(M_PI / 2);
		static::assertSame(AngleUnit::Rad, $b->unit());
		static::assertSame(M_PI / 2, $b->value());
		static::assertSame(2, $b->precision());
	}
}