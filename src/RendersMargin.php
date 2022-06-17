<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait RendersMargin {
	protected function renderMargin(EdgeInsets $margin): string {
		$style = "";

		if ($margin->left !== null) {
			$style .= "margin-left: {$margin->left->toEmittable()};";
		}

		if ($margin->right !== null) {
			$style .= "margin-right: {$margin->right->toEmittable()};";
		}

		if ($margin->top !== null) {
			$style .= "margin-top: {$margin->top->toEmittable()};";
		}

		if ($margin->bottom !== null) {
			$style .= "margin-bottom: {$margin->bottom->toEmittable()};";
		}

		return $style;
	}
}