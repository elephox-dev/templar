<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum ColorRank implements Hashable {
	case Primary;
	case Secondary;
	case Tertiary;

	public function getHashCode(): float {
		return HashBuilder::hashEnum($this);
	}
}