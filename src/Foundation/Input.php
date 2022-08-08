<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\InputType;
use Elephox\Templar\RenderContext;

abstract class Input extends HtmlRenderWidget {
	public function __construct(
		protected readonly InputType $type,
		protected readonly ?bool $autocomplete = null,
		protected readonly bool $autofocus = false,
		protected readonly bool $disabled = false,
		protected readonly bool $formnovalidate = false,
		protected readonly ?string $list = null,
		protected readonly ?string $name = null,
		protected readonly ?string $pattern = null,
		protected readonly ?string $placeholder = null,
		protected readonly bool $readonly = false,
		protected readonly bool $required = false,
		protected readonly ?int $size = null,
		protected readonly ?string $value = null,
	) {}

	protected function getTag(): string {
		return "input";
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		$attributes['type'] = $this->type->value;

		if ($this->autocomplete !== null) {
			$attributes['autocomplete'] = $this->autocomplete ? 'on' : 'off';
		}

		if ($this->autofocus) {
			$attributes['autofocus'] = 'autofocus';
		}

		if ($this->disabled) {
			$attributes['disabled'] = 'disabled';
		}

		if ($this->formnovalidate) {
			$attributes['formnovalidate'] = 'formnovalidate';
		}

		if ($this->list !== null) {
			$attributes['list'] = $this->list;
		}

		if ($this->name !== null) {
			$attributes['name'] = $this->name;
		}

		if ($this->pattern !== null) {
			$attributes['pattern'] = $this->pattern;
		}

		if ($this->placeholder !== null) {
			$attributes['placeholder'] = $this->placeholder;
		}

		if ($this->readonly) {
			$attributes['readonly'] = 'readonly';
		}

		if ($this->required) {
			$attributes['required'] = 'required';
		}

		if ($this->size !== null) {
			$attributes['size'] = $this->size;
		}

		if ($this->value !== null) {
			$attributes['value'] = $this->value;
		}

		return $attributes;
	}

	protected function renderContent(RenderContext $context): string {
		return "";
	}
}