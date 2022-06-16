<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Document extends HtmlRenderWidget {
	public function __construct(
		private readonly Head $head,
		private readonly Body $body,
	) {
	}

	public function render(RenderContext $context): string {
		return '<!DOCTYPE html>' . parent::render($context);
	}

	protected function getTag(): string {
		return 'html';
	}

	protected function renderChild(RenderContext $context): string {
		$body = $this->body->render($context);

		// render head after body, so scripts can be injected from body widgets
		$head = $this->head->render($context);

		return $head . $body;
	}
}
