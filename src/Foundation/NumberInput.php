<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HashBuilder;
use Elephox\Templar\InputType;
use Elephox\Templar\RenderContext;

class NumberInput extends Input {
	public function __construct(
		?bool $autocomplete = null,
		bool $autofocus = false,
		bool $disabled = false,
		bool $formnovalidate = false,
		?string $list = null,
		?string $name = null,
		?string $pattern = null,
		?string $placeholder = null,
		bool $readonly = false,
		bool $required = false,
		?int $size = null,
		?string $value = null,
		protected readonly null|int|float $max = null,
		protected readonly null|int|float $min = null,
		protected readonly null|int|float $step = null,
	) {
		parent::__construct(
			InputType::Number,
			$autocomplete,
			$autofocus,
			$disabled,
			$formnovalidate,
			$list,
			$name,
			$pattern,
			$placeholder,
			$readonly,
			$required,
			$size,
			$value,
		);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->type,
		);
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		if ($this->max !== null) {
			$attributes['max'] = $this->max;
		}

		if ($this->min !== null) {
			$attributes['min'] = $this->min;
		}

		if ($this->step !== null) {
			$attributes['step'] = $this->step;
		}

		return $attributes;
	}
}