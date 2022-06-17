<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait RendersBoxShadows {
	protected function renderBoxShadows(array $shadows): string {
		if (empty($shadows)) {
			return '';
		}

		return "box-shadow: " . implode(', ', $shadows) . ";";
	}
}