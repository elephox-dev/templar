<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum BorderStyle: string implements Hashable {
	use HasEnumHashCode;

	case Solid = 'solid';
	case Dashed = 'dashed';
	case Dotted = 'dotted';
	case Double = 'double';
	case Groove = 'groove';
	case Inset = 'inset';
	case Outset = 'outset';
	case Ridge = 'ridge';
	case None = 'none';
	case Hidden = 'hidden';
}