<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class InlineScript extends HeadWidget {
	public function __construct(
		protected readonly string $content,
		protected readonly string $type = 'text/javascript',
	) {}

	protected function renderContent(RenderContext $context): string {
		return $this->content;
	}

	protected function getTag(): string {
		return 'script';
	}

	protected function getAttributes(RenderContext $context): array {
		return array_merge(
			parent::getAttributes($context),
			['type' => $this->type]
		);
	}
}