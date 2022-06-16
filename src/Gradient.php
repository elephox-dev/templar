<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

abstract class Gradient implements Stringable, Hashable {
	/**
	 * @param iterable<float, Color> $stops
	 */
	public function __construct(
		protected readonly iterable $stops,
	) {}
}