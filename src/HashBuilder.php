<?php
declare(strict_types=1);

namespace Elephox\Templar;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use UnitEnum;

class HashBuilder implements Hashable {
	public const DefaultInitializer = 17;
	public const DefaultMultiplier = 37;

	public static function from(mixed ...$parts): HashBuilder {
		return new HashBuilder(parts: $parts);
	}

	public static function buildHash(mixed ...$parts): int {
		return self::from(parts: $parts)->getHashCode();
	}

	public static function hashString(Stringable|string $string): int {
		return crc32((string)$string);
	}

	public static function hashIterable(iterable $iterable): int {
		$builder = new HashBuilder();
		foreach ($iterable as $part) {
			$builder->append($part);
		}
		return $builder->getHashCode();
	}

	public static function hashEnum(UnitEnum $member): int {
		if ($member instanceof Stringable) {
			return self::hashString((string)$member);
		}

		if ($member instanceof BackedEnum) {
			return self::hashValue($member->value);
		}

		return self::hashString($member->name);
	}

	public static function hashValue(mixed $value): int {
		if (is_int($value)) {
			return $value;
		}

		if (is_float($value)) {
			return self::hashString((string)$value);
		}

		if (is_string($value) || $value instanceof Stringable) {
			return self::hashString($value);
		}

		if ($value === null) {
			return 0;
		}

		if (is_bool($value)) {
			return $value ? 1 : 0;
		}

		if (is_iterable($value)) {
			return self::hashIterable($value);
		}

		if ($value instanceof Hashable) {
			return $value->getHashCode();
		}

		if ($value instanceof UnitEnum) {
			return self::hashEnum($value);
		}

		throw new InvalidArgumentException(
			"Value of type '" . get_debug_type($value) . "' cannot be hashed."
		);
	}

	private int $hash;

	public function __construct(
		int $initializer = self::DefaultInitializer,
		private readonly int $multiplier = self::DefaultMultiplier,
		iterable $parts = [],
	) {
		assert($initializer % 2 !== 0, 'Initializer must be odd.');
		assert($multiplier % 2 !== 0, 'Multiplier must be odd.');

		$this->hash = $initializer;

		foreach ($parts as $part) {
			$this->append($part);
		}
	}

	public function append(mixed $part): self {
		$this->hash = (int)($this->multiplier * $this->hash) + self::hashValue($part);

		return $this;
	}

	public function getHashCode(): int {
		return $this->hash;
	}
}