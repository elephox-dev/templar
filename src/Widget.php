<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class Widget
{
	abstract public function render(): string;
}
