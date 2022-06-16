<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Head extends HtmlRenderWidget {
	public function __construct(
		private readonly ?string $title = null,
	) {}

	protected function renderChild(RenderContext $context): string {
		$title = $this->title ?? $context->documentMeta?->title;

		return <<<HTML
<title>$title</title>

{$this->renderMetas($context)}
HTML;
	}

	protected function getTag(): string {
		return 'head';
	}

	protected function renderStyleContent(RenderContext $context): string {
		return '';
	}

	private function renderMetas(RenderContext $context): string {
		return <<<HTML
<meta charset="{$context->documentMeta?->charset}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="./style.css">
HTML;
	}

	public function getHashCode(): int {
		return hexdec(substr(md5($this->title ?? ''), 0, 8));
	}
}
