<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait RendersPadding {
	protected function renderPadding(
		EdgeInsets $padding,
	): string {
		$style = "";

		if ($padding->left !== null) {
			$style .= "padding-left: {$padding->left->toEmittable()};";
		}

		if ($padding->right !== null) {
			$style .= "padding-right: {$padding->right->toEmittable()};";
		}

		if ($padding->top !== null) {
			$style .= "padding-top: {$padding->top->toEmittable()};";
		}

		if ($padding->bottom !== null) {
			$style .= "padding-bottom: {$padding->bottom->toEmittable()};";
		}

		return $style;
	}
}