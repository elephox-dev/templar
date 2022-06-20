<?php
declare(strict_types=1);

namespace Elephox\Templar;

interface Hashable {
	public function getHashCode(): float;
}
