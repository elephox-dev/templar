<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Head extends HtmlRenderWidget {
	public function __construct(
		protected readonly string $styleHref = "./style.css",
	) {}

	protected function renderContent(RenderContext $context): string {
		return <<<HTML
<title>{$context->meta->title}</title>

{$this->renderMetas($context)}
HTML;
	}

	protected function getTag(): string {
		return 'head';
	}

	protected function renderMetas(RenderContext $context): string {
		$metaTags = "";
		foreach ($context->meta->metas as $name => $content) {
			$metaTags .= <<<HTML
<meta name="$name" content="$content">
HTML;
		}

		return <<<HTML
<meta charset="{$context->meta->charset}">

<link rel="stylesheet" href="{$this->styleHref}">
$metaTags
HTML;
	}

	public function getHashCode(): float {
		return 0.0;
	}
}
