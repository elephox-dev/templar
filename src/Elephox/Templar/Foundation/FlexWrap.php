<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

enum FlexWrap: string
{
	case NoWrap = 'nowrap';
	case Wrap = 'wrap';
	case WrapReverse = 'wrap-reverse';
}
