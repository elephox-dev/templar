<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Head extends HtmlRenderWidget {
	protected function renderContent(RenderContext $context): string {
		return <<<HTML
<title>{$context->meta->title}</title>
{$this->renderBase($context)}
{$this->renderMetas($context)}
{$this->renderLinks($context)}
{$this->renderStyles($context)}
{$this->renderScripts($context)}
HTML;
	}

	protected function getTag(): string {
		return 'head';
	}

	protected function renderBase(RenderContext $context): string {
		if ($context->meta->base) {
			return <<<HTML
<base href="{$context->meta->base}">
HTML;
		}

		return "";
	}

	protected function renderMetas(RenderContext $context): string {
		$metaTags = "";
		foreach ($context->meta->metas as $name => $content) {
			$metaTags .= "<meta name=\"$name\" content=\"$content\">";
		}

		return "<meta charset=\"{$context->meta->charset}\">$metaTags";
	}

	protected function renderLinks(RenderContext $context): string {
		$linkTags = "";
		foreach ($context->meta->links as $href => $rel) {
			$linkTags .= "<link rel=\"$rel\" href=\"$href\">";
		}

		return $linkTags;
	}

	protected function renderStyles(RenderContext $context): string {
		$styleTags = "";
		foreach ($context->meta->styles as $source) {
			$styleTags .= "<style>$source</style>";
		}

		return $styleTags;
	}

	protected function renderScripts(RenderContext $context): string {
		$scriptTags = "";
		foreach ($context->meta->scripts as $source) {
			$scriptTags .= "<script type=\"text/javascript\">$source</script>";
		}

		return $scriptTags;
	}

	public function getHashCode(): float {
		return 0.0;
	}
}
