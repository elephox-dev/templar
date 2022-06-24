<?php
declare(strict_types=1);

namespace Elephox\Templar;

interface IconData extends Emittable {
	public function getName(): string;

	public function getStyleSelector(): string;

	public function renderStyleContent(): string;
}
