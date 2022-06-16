<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\DocumentMeta;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;

class Document extends HtmlRenderWidget {
	public function __construct(
		private readonly Head $head,
		private readonly Body $body,
		public ?DocumentMeta $documentMeta = null,
	) {
	}

	public function render(RenderContext $context): string {
		if ($this->documentMeta !== null) {
			$context->documentMeta = $this->documentMeta;
		}

		return '<!DOCTYPE html>' . parent::render($context);
	}

	protected function getTag(): string {
		return 'html';
	}

	protected function getAttributes(RenderContext $context): array {
		return parent::getAttributes($context) + [
				'lang' => $context->documentMeta?->language,
			];
	}

	protected function renderChild(RenderContext $context): string {
		$body = $this->body->render($context);

		// render head after body, so scripts can be injected from body widgets
		$head = $this->head->render($context);

		return $head . $body;
	}

	public function renderStyle(RenderContext $context): string {
		$myStyle = parent::renderStyle($context);
		$headStyle = $this->head->renderStyle($context);
		$bodyStyle = $this->body->renderStyle($context);
		return <<<CSS
$myStyle
$headStyle
$bodyStyle
CSS;
	}

	protected function renderStyleContent(RenderContext $context): string {
		return '';
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes($this->head->getHashCode(), $this->body->getHashCode());
	}
}
