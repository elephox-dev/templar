<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class SelectOption extends HtmlRenderWidget {
	public function __construct(
		protected readonly string $label,
		protected readonly ?string $value = null,
		protected readonly bool $selected = false,
		protected readonly bool $disabled = false,
	) {}

	public function getHashCode(): float {
		return HashBuilder::buildHash();
	}

	protected function renderContent(RenderContext $context): string {
		return $this->label;
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		if ($this->value !== null) {
			$attributes['value'] = $this->value;
		}

		if ($this->selected) {
			$attributes['selected'] = 'selected';
		}

		if ($this->disabled) {
			$attributes['disabled'] = 'disabled';
		}

		return $attributes;
	}

	protected function getTag(): string {
		return 'option';
	}
}