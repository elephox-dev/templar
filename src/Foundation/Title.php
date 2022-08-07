<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class Title extends HeadWidget {
	public function __construct(
		protected readonly string $title,
	) {}

	protected function renderContent(RenderContext $context): string {
		return $this->title;
	}

	protected function getTag(): string {
		return 'title';
	}
}