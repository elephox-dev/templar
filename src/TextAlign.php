<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum TextAlign: string implements Hashable {
	use HasEnumHashCode;

	case Left = 'left';
	case Right = 'right';
	case Center = 'center';
	case Justify = 'justify';
	case Start = 'start';
	case End = 'end';
}