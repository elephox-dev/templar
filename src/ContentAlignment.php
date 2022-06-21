<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum ContentAlignment: string implements Hashable {
	use HasEnumHashCode;

	case Start = 'flex-start';
	case Center = 'center';
	case End = 'flex-end';
	case SpaceBetween = 'space-between';
	case SpaceAround = 'space-around';
	case Stretch = 'stretch';
}
