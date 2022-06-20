<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasEnumHashCode {
	public function getHashCode(): int {
		return HashBuilder::hashEnum($this);
	}
}
