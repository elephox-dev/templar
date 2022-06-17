<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

interface Emittable extends Stringable, Hashable {
	public function toEmittable(): string;
}