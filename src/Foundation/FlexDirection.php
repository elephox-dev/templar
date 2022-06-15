<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

enum FlexDirection: string
{
	case Row = 'row';
	case RowReverse = 'row-reverse';
	case Column = 'column';
	case ColumnReverse = 'column-reverse';
}
