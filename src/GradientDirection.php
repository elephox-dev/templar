<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum GradientDirection: string implements Hashable {
	use HasEnumHashCode;

	case ToLeft = 'to left';
	case ToRight = 'to right';
	case ToTop = 'to top';
	case ToBottom = 'to bottom';
	case ToTopLeft = 'to top left';
	case ToTopRight = 'to top right';
	case ToBottomLeft = 'to bottom left';
	case ToBottomRight = 'to bottom right';
}