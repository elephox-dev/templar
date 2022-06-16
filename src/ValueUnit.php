<?php
declare(strict_types=1);

namespace Elephox\Templar;

interface ValueUnit {
	public function toString(): string;
}