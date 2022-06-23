<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Document extends HtmlRenderWidget {
	public function __construct(
		private readonly Head $head,
		private readonly Body $body,
	) {
		$this->head->renderParent = $this;
		$this->body->renderParent = $this;
	}

	public function render(RenderContext $context): string {
		return '<!DOCTYPE html>' . parent::render($context);
	}

	protected function getTag(): string {
		return 'html';
	}

	protected function getAttributes(RenderContext $context): array {
		return [...parent::getAttributes($context), 'lang' => $context->meta->language];
	}

	protected function renderContent(RenderContext $context): string {
		$body = $this->body->render($context);

		// render head after body, so metas can be injected from body widgets
		$head = $this->head->render($context);

		return $head . $body;
	}

	public function renderStyle(RenderContext $context): string {
		$myStyle = parent::renderStyle($context);
		$bodyStyle = $this->body->renderStyle($context);
		$headStyle = $this->head->renderStyle($context);

		return $myStyle . $headStyle . $bodyStyle;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->head,
			$this->body,
		);
	}
}
