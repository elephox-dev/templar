<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Angle;
use Elephox\Templar\AngleUnit;

it(
	'represents the correct value in deg',
	function () {
		$a = Angle::inDeg(90);
		expect(AngleUnit::Deg)->toBe($a->unit())
			->and(90.0)->toBe($a->value())
			->and(2)->toBe($a->precision());
	}
);

it(
	'represents the correct value in rad',
	function () {
		$b = Angle::inRad(M_PI / 2);
		expect(AngleUnit::Rad)->toBe($b->unit())
			->and(M_PI / 2)->toBe($b->value())
			->and(2)->toBe($b->precision());
	}
);
