<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework;

use const DEBUG_BACKTRACE_IGNORE_ARGS;
use const PHP_EOL;
use function array_key_exists;
use function array_shift;
use function array_unshift;
use function assert;
use function class_exists;
use function count;
use function debug_backtrace;
use function explode;
use function file_get_contents;
use function func_get_args;
use function implode;
use function interface_exists;
use function is_array;
use function is_bool;
use function is_int;
use function is_iterable;
use function is_object;
use function is_string;
use function preg_match;
use function preg_split;
use function sprintf;
use function strpos;
use ArrayAccess;
use Countable;
use DOMAttr;
use DOMDocument;
use DOMElement;
use PHPUnit\Framework\Constraint\ArrayHasKey;
use PHPUnit\Framework\Constraint\ArraySubset;
use PHPUnit\Framework\Constraint\Attribute;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\Constraint\ClassHasAttribute;
use PHPUnit\Framework\Constraint\ClassHasStaticAttribute;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\Count;
use PHPUnit\Framework\Constraint\DirectoryExists;
use PHPUnit\Framework\Constraint\FileExists;
use PHPUnit\Framework\Constraint\GreaterThan;
use PHPUnit\Framework\Constraint\IsAnything;
use PHPUnit\Framework\Constraint\IsEmpty;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsFalse;
use PHPUnit\Framework\Constraint\IsFinite;
use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\Constraint\IsInfinite;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\Constraint\IsJson;
use PHPUnit\Framework\Constraint\IsNan;
use PHPUnit\Framework\Constraint\IsNull;
use PHPUnit\Framework\Constraint\IsReadable;
use PHPUnit\Framework\Constraint\IsTrue;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\Constraint\IsWritable;
use PHPUnit\Framework\Constraint\JsonMatches;
use PHPUnit\Framework\Constraint\LessThan;
use PHPUnit\Framework\Constraint\LogicalAnd;
use PHPUnit\Framework\Constraint\LogicalNot;
use PHPUnit\Framework\Constraint\LogicalOr;
use PHPUnit\Framework\Constraint\LogicalXor;
use PHPUnit\Framework\Constraint\ObjectHasAttribute;
use PHPUnit\Framework\Constraint\RegularExpression;
use PHPUnit\Framework\Constraint\SameSize;
use PHPUnit\Framework\Constraint\StringContains;
use PHPUnit\Framework\Constraint\StringEndsWith;
use PHPUnit\Framework\Constraint\StringMatchesFormatDescription;
use PHPUnit\Framework\Constraint\StringStartsWith;
use PHPUnit\Framework\Constraint\TraversableContains;
use PHPUnit\Framework\Constraint\TraversableContainsEqual;
use PHPUnit\Framework\Constraint\TraversableContainsIdentical;
use PHPUnit\Framework\Constraint\TraversableContainsOnly;
use PHPUnit\Util\Type;
use PHPUnit\Util\Xml;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use Traversable;

/**
 * A set of assertion methods.
 */
abstract class Assert
{
    /**
     * @var int
     */
    private static $count = 0;

    /**
     * Asserts that an array has a specified key.
     *
     * @param int|string        $key
     * @param array|ArrayAccess $array
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertArrayHasKey($key, $array, string $message = ''): void
    {
        if (!(is_int($key) || is_string($key))) {
            throw InvalidArgumentException::create(
                1,
                'integer or string'
            );
        }

        if (!(is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        $constraint = new ArrayHasKey($key);

        static::assertThat($array, $constraint, $message);
    }

    /**
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess $subset
     * @param array|ArrayAccess $array
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @codeCoverageIgnore
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3494
     */
    public static function assertArraySubset($subset, $array, bool $checkForObjectIdentity = false, string $message = ''): void
    {
        self::createWarning('assertArraySubset() is deprecated and will be removed in PHPUnit 9.');

        if (!(is_array($subset) || $subset instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                1,
                'array or ArrayAccess'
            );
        }

        if (!(is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        $constraint = new ArraySubset($subset, $checkForObjectIdentity);

        static::assertThat($array, $constraint, $message);
    }

    /**
     * Asserts that an array does not have a specified key.
     *
     * @param int|string        $key
     * @param array|ArrayAccess $array
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertArrayNotHasKey($key, $array, string $message = ''): void
    {
        if (!(is_int($key) || is_string($key))) {
            throw InvalidArgumentException::create(
                1,
                'integer or string'
            );
        }

        if (!(is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        $constraint = new LogicalNot(
            new ArrayHasKey($key)
        );

        static::assertThat($array, $constraint, $message);
    }

    /**
     * Asserts that a haystack contains a needle.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertContains($needle, $haystack, string $message = '', bool $ignoreCase = false, bool $checkForObjectIdentity = true, bool $checkForNonObjectIdentity = false): void
    {
        // @codeCoverageIgnoreStart
        if (is_string($haystack)) {
            self::createWarning('Using assertContains() with string haystacks is deprecated and will not be supported in PHPUnit 9. Refactor your test to use assertStringContainsString() or assertStringContainsStringIgnoringCase() instead.');
        }

        if (!$checkForObjectIdentity) {
            self::createWarning('The optional $checkForObjectIdentity parameter of assertContains() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertContainsEquals() instead.');
        }

        if ($checkForNonObjectIdentity) {
            self::createWarning('The optional $checkForNonObjectIdentity parameter of assertContains() is deprecated and will be removed in PHPUnit 9.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertContains() is deprecated and will be removed in PHPUnit 9.');
        }
        // @codeCoverageIgnoreEnd

        if (is_array($haystack) ||
            (is_object($haystack) && $haystack instanceof Traversable)) {
            $constraint = new TraversableContains(
                $needle,
                $checkForObjectIdentity,
                $checkForNonObjectIdentity
            );
        } elseif (is_string($haystack)) {
            if (!is_string($needle)) {
                throw InvalidArgumentException::create(
                    1,
                    'string'
                );
            }

            $constraint = new StringContains(
                $needle,
                $ignoreCase
            );
        } else {
            throw InvalidArgumentException::create(
                2,
                'array, traversable or string'
            );
        }

        static::assertThat($haystack, $constraint, $message);
    }

    public static function assertContainsEquals($needle, iterable $haystack, string $message = ''): void
    {
        $constraint = new TraversableContainsEqual($needle);

        static::assertThat($haystack, $constraint, $message);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains a needle.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeContains($needle, string $haystackAttributeName, $haystackClassOrObject, string $message = '', bool $ignoreCase = false, bool $checkForObjectIdentity = true, bool $checkForNonObjectIdentity = false): void
    {
        self::createWarning('assertAttributeContains() is deprecated and will be removed in PHPUnit 9.');

        static::assertContains(
            $needle,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message,
            $ignoreCase,
            $checkForObjectIdentity,
            $checkForNonObjectIdentity
        );
    }

    /**
     * Asserts that a haystack does not contain a needle.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertNotContains($needle, $haystack, string $message = '', bool $ignoreCase = false, bool $checkForObjectIdentity = true, bool $checkForNonObjectIdentity = false): void
    {
        // @codeCoverageIgnoreStart
        if (is_string($haystack)) {
            self::createWarning('Using assertNotContains() with string haystacks is deprecated and will not be supported in PHPUnit 9. Refactor your test to use assertStringNotContainsString() or assertStringNotContainsStringIgnoringCase() instead.');
        }

        if (!$checkForObjectIdentity) {
            self::createWarning('The optional $checkForObjectIdentity parameter of assertNotContains() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertNotContainsEquals() instead.');
        }

        if ($checkForNonObjectIdentity) {
            self::createWarning('The optional $checkForNonObjectIdentity parameter of assertNotContains() is deprecated and will be removed in PHPUnit 9.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertNotContains() is deprecated and will be removed in PHPUnit 9.');
        }
        // @codeCoverageIgnoreEnd

        if (is_array($haystack) ||
            (is_object($haystack) && $haystack instanceof Traversable)) {
            $constraint = new LogicalNot(
                new TraversableContains(
                    $needle,
                    $checkForObjectIdentity,
                    $checkForNonObjectIdentity
                )
            );
        } elseif (is_string($haystack)) {
            if (!is_string($needle)) {
                throw InvalidArgumentException::create(
                    1,
                    'string'
                );
            }

            $constraint = new LogicalNot(
                new StringContains(
                    $needle,
                    $ignoreCase
                )
            );
        } else {
            throw InvalidArgumentException::create(
                2,
                'array, traversable or string'
            );
        }

        static::assertThat($haystack, $constraint, $message);
    }

    public static function assertNotContainsEquals($needle, iterable $haystack, string $message = ''): void
    {
        $constraint = new LogicalNot(new TraversableContainsEqual($needle));

        static::assertThat($haystack, $constraint, $message);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain a needle.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotContains($needle, string $haystackAttributeName, $haystackClassOrObject, string $message = '', bool $ignoreCase = false, bool $checkForObjectIdentity = true, bool $checkForNonObjectIdentity = false): void
    {
        self::createWarning('assertAttributeNotContains() is deprecated and will be removed in PHPUnit 9.');

        static::assertNotContains(
            $needle,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message,
            $ignoreCase,
            $checkForObjectIdentity,
            $checkForNonObjectIdentity
        );
    }

    /**
     * Asserts that a haystack contains only values of a given type.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertContainsOnly(string $type, iterable $haystack, ?bool $isNativeType = null, string $message = ''): void
    {
        if ($isNativeType === null) {
            $isNativeType = Type::isType($type);
        }

        static::assertThat(
            $haystack,
            new TraversableContainsOnly(
                $type,
                $isNativeType
            ),
            $message
        );
    }

    /**
     * Asserts that a haystack contains only instances of a given class name.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertContainsOnlyInstancesOf(string $className, iterable $haystack, string $message = ''): void
    {
        static::assertThat(
            $haystack,
            new TraversableContainsOnly(
                $className,
                false
            ),
            $message
        );
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains only values of a given type.
     *
     * @param object|string $haystackClassOrObject
     * @param bool          $isNativeType
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeContainsOnly(string $type, string $haystackAttributeName, $haystackClassOrObject, ?bool $isNativeType = null, string $message = ''): void
    {
        self::createWarning('assertAttributeContainsOnly() is deprecated and will be removed in PHPUnit 9.');

        static::assertContainsOnly(
            $type,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $isNativeType,
            $message
        );
    }

    /**
     * Asserts that a haystack does not contain only values of a given type.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotContainsOnly(string $type, iterable $haystack, ?bool $isNativeType = null, string $message = ''): void
    {
        if ($isNativeType === null) {
            $isNativeType = Type::isType($type);
        }

        static::assertThat(
            $haystack,
            new LogicalNot(
                new TraversableContainsOnly(
                    $type,
                    $isNativeType
                )
            ),
            $message
        );
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain only values of a given
     * type.
     *
     * @param object|string $haystackClassOrObject
     * @param bool          $isNativeType
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotContainsOnly(string $type, string $haystackAttributeName, $haystackClassOrObject, ?bool $isNativeType = null, string $message = ''): void
    {
        self::createWarning('assertAttributeNotContainsOnly() is deprecated and will be removed in PHPUnit 9.');

        static::assertNotContainsOnly(
            $type,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $isNativeType,
            $message
        );
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param Countable|iterable $haystack
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertCount(int $expectedCount, $haystack, string $message = ''): void
    {
        if (!$haystack instanceof Countable && !is_iterable($haystack)) {
            throw InvalidArgumentException::create(2, 'countable or iterable');
        }

        static::assertThat(
            $haystack,
            new Count($expectedCount),
            $message
        );
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeCount(int $expectedCount, string $haystackAttributeName, $haystackClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeCount() is deprecated and will be removed in PHPUnit 9.');

        static::assertCount(
            $expectedCount,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message
        );
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param Countable|iterable $haystack
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertNotCount(int $expectedCount, $haystack, string $message = ''): void
    {
        if (!$haystack instanceof Countable && !is_iterable($haystack)) {
            throw InvalidArgumentException::create(2, 'countable or iterable');
        }

        $constraint = new LogicalNot(
            new Count($expectedCount)
        );

        static::assertThat($haystack, $constraint, $message);
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotCount(int $expectedCount, string $haystackAttributeName, $haystackClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeNotCount() is deprecated and will be removed in PHPUnit 9.');

        static::assertNotCount(
            $expectedCount,
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message
        );
    }

    /**
     * Asserts that two variables are equal.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertEquals($expected, $actual, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($delta !== 0.0) {
            self::createWarning('The optional $delta parameter of assertEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertEqualsWithDelta() instead.');
        }

        if ($maxDepth !== 10) {
            self::createWarning('The optional $maxDepth parameter of assertEquals() is deprecated and will be removed in PHPUnit 9.');
        }

        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertEqualsCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertEqualsIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        $constraint = new IsEqual(
            $expected,
            $delta,
            $maxDepth,
            $canonicalize,
            $ignoreCase
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are equal (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertEqualsCanonicalizing($expected, $actual, string $message = ''): void
    {
        $constraint = new IsEqual(
            $expected,
            0.0,
            10,
            true,
            false
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are equal (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertEqualsIgnoringCase($expected, $actual, string $message = ''): void
    {
        $constraint = new IsEqual(
            $expected,
            0.0,
            10,
            false,
            true
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are equal (with delta).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertEqualsWithDelta($expected, $actual, float $delta, string $message = ''): void
    {
        $constraint = new IsEqual(
            $expected,
            $delta
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that a variable is equal to an attribute of an object.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeEquals($expected, string $actualAttributeName, $actualClassOrObject, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void
    {
        self::createWarning('assertAttributeEquals() is deprecated and will be removed in PHPUnit 9.');

        static::assertEquals(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message,
            $delta,
            $maxDepth,
            $canonicalize,
            $ignoreCase
        );
    }

    /**
     * Asserts that two variables are not equal.
     *
     * @param float $delta
     * @param int   $maxDepth
     * @param bool  $canonicalize
     * @param bool  $ignoreCase
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotEquals($expected, $actual, string $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($delta !== 0.0) {
            self::createWarning('The optional $delta parameter of assertNotEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertNotEqualsWithDelta() instead.');
        }

        if ($maxDepth !== 10) {
            self::createWarning('The optional $maxDepth parameter of assertNotEquals() is deprecated and will be removed in PHPUnit 9.');
        }

        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertNotEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertNotEqualsCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertNotEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertNotEqualsIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        $constraint = new LogicalNot(
            new IsEqual(
                $expected,
                $delta,
                $maxDepth,
                $canonicalize,
                $ignoreCase
            )
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are not equal (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotEqualsCanonicalizing($expected, $actual, string $message = ''): void
    {
        $constraint = new LogicalNot(
            new IsEqual(
                $expected,
                0.0,
                10,
                true,
                false
            )
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are not equal (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotEqualsIgnoringCase($expected, $actual, string $message = ''): void
    {
        $constraint = new LogicalNot(
            new IsEqual(
                $expected,
                0.0,
                10,
                false,
                true
            )
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that two variables are not equal (with delta).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotEqualsWithDelta($expected, $actual, float $delta, string $message = ''): void
    {
        $constraint = new LogicalNot(
            new IsEqual(
                $expected,
                $delta
            )
        );

        static::assertThat($actual, $constraint, $message);
    }

    /**
     * Asserts that a variable is not equal to an attribute of an object.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotEquals($expected, string $actualAttributeName, $actualClassOrObject, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void
    {
        self::createWarning('assertAttributeNotEquals() is deprecated and will be removed in PHPUnit 9.');

        static::assertNotEquals(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message,
            $delta,
            $maxDepth,
            $canonicalize,
            $ignoreCase
        );
    }

    /**
     * Asserts that a variable is empty.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert empty $actual
     */
    public static function assertEmpty($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isEmpty(), $message);
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is empty.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeEmpty(string $haystackAttributeName, $haystackClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeEmpty() is deprecated and will be removed in PHPUnit 9.');

        static::assertEmpty(
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message
        );
    }

    /**
     * Asserts that a variable is not empty.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert !empty $actual
     */
    public static function assertNotEmpty($actual, string $message = ''): void
    {
        static::assertThat($actual, static::logicalNot(static::isEmpty()), $message);
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is not empty.
     *
     * @param object|string $haystackClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotEmpty(string $haystackAttributeName, $haystackClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeNotEmpty() is deprecated and will be removed in PHPUnit 9.');

        static::assertNotEmpty(
            static::readAttribute($haystackClassOrObject, $haystackAttributeName),
            $message
        );
    }

    /**
     * Asserts that a value is greater than another value.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertGreaterThan($expected, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::greaterThan($expected), $message);
    }

    /**
     * Asserts that an attribute is greater than another value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeGreaterThan($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeGreaterThan() is deprecated and will be removed in PHPUnit 9.');

        static::assertGreaterThan(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message
        );
    }

    /**
     * Asserts that a value is greater than or equal to another value.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertGreaterThanOrEqual($expected, $actual, string $message = ''): void
    {
        static::assertThat(
            $actual,
            static::greaterThanOrEqual($expected),
            $message
        );
    }

    /**
     * Asserts that an attribute is greater than or equal to another value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeGreaterThanOrEqual($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeGreaterThanOrEqual() is deprecated and will be removed in PHPUnit 9.');

        static::assertGreaterThanOrEqual(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message
        );
    }

    /**
     * Asserts that a value is smaller than another value.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertLessThan($expected, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::lessThan($expected), $message);
    }

    /**
     * Asserts that an attribute is smaller than another value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeLessThan($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeLessThan() is deprecated and will be removed in PHPUnit 9.');

        static::assertLessThan(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message
        );
    }

    /**
     * Asserts that a value is smaller than or equal to another value.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertLessThanOrEqual($expected, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::lessThanOrEqual($expected), $message);
    }

    /**
     * Asserts that an attribute is smaller than or equal to another value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeLessThanOrEqual($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeLessThanOrEqual() is deprecated and will be removed in PHPUnit 9.');

        static::assertLessThanOrEqual(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message
        );
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileEquals(string $expected, string $actual, string $message = '', bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertFileEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertFileEqualsCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertFileEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertFileEqualsIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new IsEqual(
            file_get_contents($expected),
            0.0,
            10,
            $canonicalize,
            $ignoreCase
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileEqualsCanonicalizing(string $expected, string $actual, string $message = ''): void
    {
        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new IsEqual(
            file_get_contents($expected),
            0.0,
            10,
            true
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileEqualsIgnoringCase(string $expected, string $actual, string $message = ''): void
    {
        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new IsEqual(
            file_get_contents($expected),
            0.0,
            10,
            false,
            true
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of
     * another file.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotEquals(string $expected, string $actual, string $message = '', bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertFileNotEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertFileNotEqualsCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertFileNotEquals() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertFileNotEqualsIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expected),
                0.0,
                10,
                $canonicalize,
                $ignoreCase
            )
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of another
     * file (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotEqualsCanonicalizing(string $expected, string $actual, string $message = ''): void
    {
        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expected),
                0.0,
                10,
                true
            )
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of another
     * file (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotEqualsIgnoringCase(string $expected, string $actual, string $message = ''): void
    {
        static::assertFileExists($expected, $message);
        static::assertFileExists($actual, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expected),
                0.0,
                10,
                false,
                true
            )
        );

        static::assertThat(file_get_contents($actual), $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringEqualsFile(string $expectedFile, string $actualString, string $message = '', bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertStringEqualsFile() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertStringEqualsFileCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertStringEqualsFile() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertStringEqualsFileIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        static::assertFileExists($expectedFile, $message);

        $constraint = new IsEqual(
            file_get_contents($expectedFile),
            0.0,
            10,
            $canonicalize,
            $ignoreCase
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringEqualsFileCanonicalizing(string $expectedFile, string $actualString, string $message = ''): void
    {
        static::assertFileExists($expectedFile, $message);

        $constraint = new IsEqual(
            file_get_contents($expectedFile),
            0.0,
            10,
            true
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringEqualsFileIgnoringCase(string $expectedFile, string $actualString, string $message = ''): void
    {
        static::assertFileExists($expectedFile, $message);

        $constraint = new IsEqual(
            file_get_contents($expectedFile),
            0.0,
            10,
            false,
            true
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringNotEqualsFile(string $expectedFile, string $actualString, string $message = '', bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // @codeCoverageIgnoreStart
        if ($canonicalize) {
            self::createWarning('The optional $canonicalize parameter of assertStringNotEqualsFile() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertStringNotEqualsFileCanonicalizing() instead.');
        }

        if ($ignoreCase) {
            self::createWarning('The optional $ignoreCase parameter of assertStringNotEqualsFile() is deprecated and will be removed in PHPUnit 9. Refactor your test to use assertStringNotEqualsFileIgnoringCase() instead.');
        }
        // @codeCoverageIgnoreEnd

        static::assertFileExists($expectedFile, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expectedFile),
                0.0,
                10,
                $canonicalize,
                $ignoreCase
            )
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file (canonicalizing).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringNotEqualsFileCanonicalizing(string $expectedFile, string $actualString, string $message = ''): void
    {
        static::assertFileExists($expectedFile, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expectedFile),
                0.0,
                10,
                true
            )
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file (ignoring case).
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertStringNotEqualsFileIgnoringCase(string $expectedFile, string $actualString, string $message = ''): void
    {
        static::assertFileExists($expectedFile, $message);

        $constraint = new LogicalNot(
            new IsEqual(
                file_get_contents($expectedFile),
                0.0,
                10,
                false,
                true
            )
        );

        static::assertThat($actualString, $constraint, $message);
    }

    /**
     * Asserts that a file/dir is readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertIsReadable(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new IsReadable, $message);
    }

    /**
     * Asserts that a file/dir exists and is not readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotIsReadable(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new LogicalNot(new IsReadable), $message);
    }

    /**
     * Asserts that a file/dir exists and is writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertIsWritable(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new IsWritable, $message);
    }

    /**
     * Asserts that a file/dir exists and is not writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotIsWritable(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new LogicalNot(new IsWritable), $message);
    }

    /**
     * Asserts that a directory exists.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryExists(string $directory, string $message = ''): void
    {
        static::assertThat($directory, new DirectoryExists, $message);
    }

    /**
     * Asserts that a directory does not exist.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryNotExists(string $directory, string $message = ''): void
    {
        static::assertThat($directory, new LogicalNot(new DirectoryExists), $message);
    }

    /**
     * Asserts that a directory exists and is readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryIsReadable(string $directory, string $message = ''): void
    {
        self::assertDirectoryExists($directory, $message);
        self::assertIsReadable($directory, $message);
    }

    /**
     * Asserts that a directory exists and is not readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryNotIsReadable(string $directory, string $message = ''): void
    {
        self::assertDirectoryExists($directory, $message);
        self::assertNotIsReadable($directory, $message);
    }

    /**
     * Asserts that a directory exists and is writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryIsWritable(string $directory, string $message = ''): void
    {
        self::assertDirectoryExists($directory, $message);
        self::assertIsWritable($directory, $message);
    }

    /**
     * Asserts that a directory exists and is not writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertDirectoryNotIsWritable(string $directory, string $message = ''): void
    {
        self::assertDirectoryExists($directory, $message);
        self::assertNotIsWritable($directory, $message);
    }

    /**
     * Asserts that a file exists.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileExists(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new FileExists, $message);
    }

    /**
     * Asserts that a file does not exist.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotExists(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new LogicalNot(new FileExists), $message);
    }

    /**
     * Asserts that a file exists and is readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileIsReadable(string $file, string $message = ''): void
    {
        self::assertFileExists($file, $message);
        self::assertIsReadable($file, $message);
    }

    /**
     * Asserts that a file exists and is not readable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotIsReadable(string $file, string $message = ''): void
    {
        self::assertFileExists($file, $message);
        self::assertNotIsReadable($file, $message);
    }

    /**
     * Asserts that a file exists and is writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileIsWritable(string $file, string $message = ''): void
    {
        self::assertFileExists($file, $message);
        self::assertIsWritable($file, $message);
    }

    /**
     * Asserts that a file exists and is not writable.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFileNotIsWritable(string $file, string $message = ''): void
    {
        self::assertFileExists($file, $message);
        self::assertNotIsWritable($file, $message);
    }

    /**
     * Asserts that a condition is true.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert true $condition
     */
    public static function assertTrue($condition, string $message = ''): void
    {
        static::assertThat($condition, static::isTrue(), $message);
    }

    /**
     * Asserts that a condition is not true.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert !true $condition
     */
    public static function assertNotTrue($condition, string $message = ''): void
    {
        static::assertThat($condition, static::logicalNot(static::isTrue()), $message);
    }

    /**
     * Asserts that a condition is false.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert false $condition
     */
    public static function assertFalse($condition, string $message = ''): void
    {
        static::assertThat($condition, static::isFalse(), $message);
    }

    /**
     * Asserts that a condition is not false.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert !false $condition
     */
    public static function assertNotFalse($condition, string $message = ''): void
    {
        static::assertThat($condition, static::logicalNot(static::isFalse()), $message);
    }

    /**
     * Asserts that a variable is null.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert null $actual
     */
    public static function assertNull($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isNull(), $message);
    }

    /**
     * Asserts that a variable is not null.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-assert !null $actual
     */
    public static function assertNotNull($actual, string $message = ''): void
    {
        static::assertThat($actual, static::logicalNot(static::isNull()), $message);
    }

    /**
     * Asserts that a variable is finite.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertFinite($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isFinite(), $message);
    }

    /**
     * Asserts that a variable is infinite.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertInfinite($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isInfinite(), $message);
    }

    /**
     * Asserts that a variable is nan.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNan($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isNan(), $message);
    }

    /**
     * Asserts that a class has a specified attribute.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertClassHasAttribute(string $attributeName, string $className, string $message = ''): void
    {
        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!class_exists($className)) {
            throw InvalidArgumentException::create(2, 'class name');
        }

        static::assertThat($className, new ClassHasAttribute($attributeName), $message);
    }

    /**
     * Asserts that a class does not have a specified attribute.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertClassNotHasAttribute(string $attributeName, string $className, string $message = ''): void
    {
        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!class_exists($className)) {
            throw InvalidArgumentException::create(2, 'class name');
        }

        static::assertThat(
            $className,
            new LogicalNot(
                new ClassHasAttribute($attributeName)
            ),
            $message
        );
    }

    /**
     * Asserts that a class has a specified static attribute.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertClassHasStaticAttribute(string $attributeName, string $className, string $message = ''): void
    {
        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!class_exists($className)) {
            throw InvalidArgumentException::create(2, 'class name');
        }

        static::assertThat(
            $className,
            new ClassHasStaticAttribute($attributeName),
            $message
        );
    }

    /**
     * Asserts that a class does not have a specified static attribute.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertClassNotHasStaticAttribute(string $attributeName, string $className, string $message = ''): void
    {
        if (!self::isValidClassAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!class_exists($className)) {
            throw InvalidArgumentException::create(2, 'class name');
        }

        static::assertThat(
            $className,
            new LogicalNot(
                new ClassHasStaticAttribute($attributeName)
            ),
            $message
        );
    }

    /**
     * Asserts that an object has a specified attribute.
     *
     * @param object $object
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertObjectHasAttribute(string $attributeName, $object, string $message = ''): void
    {
        if (!self::isValidObjectAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!is_object($object)) {
            throw InvalidArgumentException::create(2, 'object');
        }

        static::assertThat(
            $object,
            new ObjectHasAttribute($attributeName),
            $message
        );
    }

    /**
     * Asserts that an object does not have a specified attribute.
     *
     * @param object $object
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     */
    public static function assertObjectNotHasAttribute(string $attributeName, $object, string $message = ''): void
    {
        if (!self::isValidObjectAttributeName($attributeName)) {
            throw InvalidArgumentException::create(1, 'valid attribute name');
        }

        if (!is_object($object)) {
            throw InvalidArgumentException::create(2, 'object');
        }

        static::assertThat(
            $object,
            new LogicalNot(
                new ObjectHasAttribute($attributeName)
            ),
            $message
        );
    }

    /**
     * Asserts that two variables have the same type and value.
     * Used on objects, it asserts that two variables reference
     * the same object.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @psalm-template ExpectedType
     * @psalm-param ExpectedType $expected
     * @psalm-assert =ExpectedType $actual
     */
    public static function assertSame($expected, $actual, string $message = ''): void
    {
        static::assertThat(
            $actual,
            new IsIdentical($expected),
            $message
        );
    }

    /**
     * Asserts that a variable and an attribute of an object have the same type
     * and value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeSame($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeSame() is deprecated and will be removed in PHPUnit 9.');

        static::assertSame(
            $expected,
            static::readAttribute($actualClassOrObject, $actualAttributeName),
            $message
        );
    }

    /**
     * Asserts that two variables do not have the same type and value.
     * Used on objects, it asserts that two variables do not reference
     * the same object.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public static function assertNotSame($expected, $actual, string $message = ''): void
    {
        if (is_bool($expected) && is_bool($actual)) {
            static::assertNotEquals($expected, $actual, $message);
        }

        static::assertThat(
            $actual,
            new LogicalNot(
                new IsIdentical($expected)
            ),
            $message
        );
    }

    /**
     * Asserts that a variable and an attribute of an object do not have the
     * same type and value.
     *
     * @param object|string $actualClassOrObject
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws ExpectationFailedException
     *
     * @deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
     * @codeCoverageIgnore
     */
    public static function assertAttributeNotSame($expected, string $actualAttributeName, $actualClassOrObject, string $message = ''): void
    {
        self::createWarning('assertAttributeNotSame() is deprecated and will be removed i