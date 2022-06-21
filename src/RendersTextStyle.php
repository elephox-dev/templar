<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait RendersTextStyle {
	protected function renderTextStyle(TextStyle $textStyle, RenderContext $context): string {
		$style = "";

		if ($textStyle->font !== null) {
			$style .= "font-family: $textStyle->font;";
		}

		if ($textStyle->weight !== null) {
			$style .= "font-weight: $textStyle->weight;";
		}

		if ($textStyle->size !== null) {
			$style .= "font-size: $textStyle->size;";
		}

		if ($textStyle->align !== null) {
			$style .= "text-align: {$textStyle->align->value};";
		}

		if ($textStyle->decoration !== null) {
			$style .= $textStyle->decoration->toEmittable();
		}

		$color = $textStyle->color ?? $context->colorScheme->foreground;
		if ($color !== null) {
			$style .= "color: $color;";
		}

		return $style;
	}
}