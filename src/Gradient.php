<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class Gradient implements BackgroundValue {
	/**
	 * @param iterable<float, Color> $stops
	 */
	public function __construct(
		protected readonly iterable $stops,
	) {}
}