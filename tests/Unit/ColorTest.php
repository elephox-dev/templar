<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\Color;
use Elephox\Templar\Foundation\Colors;

it(
	'converts to and from HSLA',
	function (array $rgba, array $hsla): void {
		$color = Color::fromRGBA($rgba[0], $rgba[1], $rgba[2], $rgba[3]);
		$arr = $color->toHslArray();
		expect($hsla[0])->toBe($arr['hue'])
			->and($hsla[1])->toBe($arr['saturation'])
			->and($hsla[2])->toBe($arr['lightness'])
			->and($hsla[3])->toBe($arr['alpha']);
		$color2 =
			Color::fromHSLA($arr['hue'], $arr['saturation'], $arr['lightness'], $arr['alpha']);
		expect($color->toHex())->toBe($color2->toHex());
	}
)->with(
	function () {
		yield [
			[0, 0, 0, 0],
			[0.0, 0.0, 0.0, 0.0],
		];

		yield [
			[255, 255, 255, 255],
			[0.0, 0.0, 100.0, 1.0],
		];

		yield [
			[255, 0, 0, 255],
			[0.0, 100.0, 50.0, 1.0],
		];

		yield [
			[0, 255, 0, 255],
			[120.0, 100.0, 50.0, 1.0],
		];

		yield [
			[0, 0, 255, 255],
			[240.0, 100.0, 50.0, 1.0],
		];

		yield [
			[255, 255, 0, 255],
			[60.0, 100.0, 50.0, 1.0],
		];

		yield [
			[255, 0, 255, 255],
			[300.0, 100.0, 50.0, 1.0],
		];

		yield [
			[0, 255, 255, 255],
			[180.0, 100.0, 50.0, 1.0],
		];
	}
);

it(
	'calculates the correct color brightness',
	function (Color $c, float $ratio) {
		$h = $c->toHex();
		$actual = $c->brightness();

		expect($actual)->toBe($ratio);
	}
)->with(
	[
		'black' => [Colors::Black(), 0.0],
		'white' => [Colors::White(), 255.0],
		'red' => [Colors::Red(), 139.44],
		'blue' => [Colors::Blue(), 86.1],
		'azure' => [Colors::Azure(), 148.09],
		'emerald' => [Colors::Emerald(), 146.95],
	]
);

it(
	'calculates the correct color contrast ratio',
	function (Color $a, Color $b, float $ratio) {
		$actual = $a->contrastRatio($b);

		expect($actual)->toBe($ratio);
	}
)->with(
	[
		'black & white' => [Colors::Black(), Colors::White(), 21.0],
		'white & black' => [Colors::White(), Colors::Black(), 21.0],
		'red & black' => [Colors::Red(), Colors::Black(), 5.25],
		'red & white' => [Colors::Red(), Colors::White(), 3.99],
		'blue & white' => [Colors::Blue(), Colors::White(), 8.59],
		'white & gray' => [Colors::White(), new Color(0x808080FF), 3.94],
		'black & gray' => [Colors::Black(), new Color(0x808080FF), 5.31],
		'azure & emerald' => [Colors::Azure(), Colors::Emerald(), 1.16],
	]
);

it(
	'calculates the correct color difference',
	function (Color $a, Color $b, float $ratio) {
		$actual = $a->difference($b);

		expect($actual)->toBe($ratio);
	}
)->with(
	[
		'black & white' => [Colors::Black(), Colors::White(), 441.67],
		'white & black' => [Colors::White(), Colors::Black(), 441.67],
		'red & black' => [Colors::Red(), Colors::Black(), 255.0],
		'red & white' => [Colors::Red(), Colors::White(), 360.62],
		'blue & white' => [Colors::Blue(), Colors::White(), 360.62],
		'white & gray' => [Colors::White(), new Color(0x808080FF), 219.97],
		'black & gray' => [Colors::Black(), new Color(0x808080FF), 221.7],
		'azure & emerald' => [Colors::Azure(), Colors::Emerald(), 178.87],
	]
);

// check using https://webaim.org/resources/contrastchecker/
it(
	'validates WCAG tests correctly',
	function (Color $a, Color $b, array $results) {
		$actual = $a->wcagTest($b);

		expect($actual)->toBe($results);
	}
)->with(
	[
		'black & white' => [
			Colors::Black(),
			Colors::White(),
			[
				'aa' => ['text' => true, 'large' => true, 'ui' => true],
				'aaa' => ['text' => true, 'large' => true]
			]
		],
		'black & gray' => [
			Colors::Black(),
			new Color(0x808080FF),
			[
				'aa' => ['text' => true, 'large' => true, 'ui' => true],
				'aaa' => ['text' => false, 'large' => true]
			]
		],
		'white & gray' => [
			Colors::White(),
			new Color(0x808080FF),
			[
				'aa' => ['text' => false, 'large' => true, 'ui' => true],
				'aaa' => ['text' => false, 'large' => false]
			]
		],
	]
);