<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\HashBuilder;
use InvalidArgumentException;
use stdClass;

it(
	'builds the same hash for the same inputs',
	static function (mixed $a, mixed $b): void {
		$aHash = HashBuilder::buildHash($a);
		$bHash = HashBuilder::buildHash($b);

		expect($aHash)->toBe($bHash);
	}
)->with(
	[
		[null, null],
		[false, false],
		[null, false],
		[true, true],
		[0, 0],
		[1, 1],
		[-1, -1],
		[0.0, 0.0],
		[1.0, 1.0],
		[-1.0, -1.0],
		['', ''],
		['a', 'a'],
		['ab', 'ab'],
		[[0, 1, 2], [0, 1, 2]],
		[Colors::White(), Colors::White()],
	]
);

it(
	'builds different hashes for different inputs',
	static function (mixed $a, mixed $b): void {
		$aHash = HashBuilder::buildHash($a);
		$bHash = HashBuilder::buildHash($b);

		expect($aHash)->not()->toBe($bHash);
	}
)->with(
	[
		[true, false],
		[1, 0],
		[Colors::White(), Colors::Black()],
		[1.1, 1.0],
	]
);

it(
	'throws for values that cannot be hashed',
	static function () {
		HashBuilder::buildHash(new stdClass());
	}
)->throws(
	InvalidArgumentException::class,
	'Value of type \'stdClass\' cannot be hashed.'
);
