<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait HasEnumHashCode {
	public function getHashCode(): int {
		return hexdec(
			substr(
				md5($this->value),
				0,
				8,
			)
		);
	}
}
