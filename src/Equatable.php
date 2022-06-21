<?php
declare(strict_types=1);

namespace Elephox\Templar;

interface Equatable {
	public function equals(mixed $other): bool;
}