<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum PositionContext: string implements Hashable {
	use HasEnumHashCode;

	case Static = 'static';
	case Relative = 'relative';
	case Absolute = 'absolute';
	case Fixed = 'fixed';
	case Flex = 'flex';
	case Float = 'float';
}
