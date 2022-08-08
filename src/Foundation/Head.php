<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Head extends HtmlRenderWidget {
	protected array $children = [];

	public function __construct(
		iterable $children = [],
	) {
		foreach ($children as $child) {
			assert(
				$child instanceof HeadWidget,
				"Head children must be HeadWidgets, '" . get_debug_type($child) . "' given",
			);

			$this->children[] = $child;
		}
	}

	public function render(RenderContext $context): string {
		$tag = $this->getTag();
		$attributes =
			$this->renderAttributes(
				$context,
				false
			);
		$content = $this->renderContent($context);

		return $this->renderHtml(
			$tag,
			$attributes,
			$content
		);
	}

	protected function renderContent(RenderContext $context): string {
		return <<<HTML
{$this->renderBase($context)}
{$this->renderMetas($context)}
{$this->renderLinks($context)}
{$this->renderStyles($context)}
{$this->renderScripts($context)}
{$this->renderChildren($context)}
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

	protected function renderChildren(RenderContext $context): string {
		$html = '';

		$titleRendered = false;
		foreach ($this->children as $child) {
			if ($child instanceof Title) {
				if ($titleRendered) {
					throw new \InvalidArgumentException(
						"Head can only contain one Title"
					);
				}

				$titleRendered = true;
			}

			$html .= $child->render($context);
		}

		if (!$titleRendered) {
			$html .= "<title>{$context->meta->title}</title>";
		}

		return $html;
	}

	public function getHashCode(): float {
		return 0.0;
	}
}
