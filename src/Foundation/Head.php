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

<style>
	{$this->renderStyle($context)}
</style>

{$this->renderMetas($context)}
HTML;
	}

	protected function getTag(): string {
		return 'head';
	}

	private function renderStyle(RenderContext $context): string {
		$colors = $context->colorScheme;
		$style = <<<CSS
body {
	background-color: $colors->background;
	color: $colors->foreground;
}
CSS;

		if ($context->darkColorScheme !== null) {
			$darkColors = $context->darkColorScheme;
			$style .= <<<CSS
@media (prefers-color-scheme: dark) {
	body {
		background-color: $darkColors->background;
		color: $darkColors->foreground;
	}
}
CSS;
		}

		return $style;
	}

	private function renderMetas(RenderContext $context): string {
		return <<<HTML
<meta charset="{$context->documentMeta?->charset}">
<meta name="viewport" content="width=device-width, initial-scale=1">
HTML;
	}
}
