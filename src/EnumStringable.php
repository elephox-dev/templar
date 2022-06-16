<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait EnumStringable {
	public function toString(): string {
		return $this->value;
	}
}