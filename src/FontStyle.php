<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum FontStyle: string implements Hashable {
	use HasEnumHashCode;

	case Normal = 'normal';
	case Italic = 'italic';
	case Oblique = 'oblique';
}