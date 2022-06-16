<?php
declare(strict_types=1);

namespace Elephox\Templar;

enum Unit: string
{
	case Px = 'px';
	case Em = 'em';
	case Rem = 'rem';
	case Percent = '%';
	case Vh = 'vh';
	case Vw = 'vw';
}
