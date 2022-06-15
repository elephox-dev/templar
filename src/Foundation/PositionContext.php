<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

enum PositionContext: string {
	case Static = 'static';
	case Relative = 'relative';
	case Absolute = 'absolute';
	case Fixed = 'fixed';
	case Flex = 'flex';
	case Float = 'float';
}
