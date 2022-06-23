<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum BoxFit implements Hashable {
	use HasEnumHashCode;

	case Contain;
	case Cover;
	case Fill;
	case ScaleDown;
}