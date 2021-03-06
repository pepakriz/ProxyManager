<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

declare(strict_types=1);

namespace ProxyManagerTest\Exception;

use PHPUnit_Framework_TestCase;
use ProxyManager\Exception\InvalidProxiedClassException;
use ProxyManagerTestAsset\BaseInterface;
use ProxyManagerTestAsset\ClassWithAbstractProtectedMethod;
use ProxyManagerTestAsset\ClassWithAbstractPublicMethod;
use ProxyManagerTestAsset\ClassWithProtectedMethod;
use ProxyManagerTestAsset\FinalClass;
use ReflectionClass;

/**
 * Tests for {@see \ProxyManager\Exception\InvalidProxiedClassException}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 *
 * @covers \ProxyManager\Exception\InvalidProxiedClassException
 * @group Coverage
 */
class InvalidProxiedClassExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testInterfaceNotSupported() : void
    {
        self::assertSame(
            'Provided interface "ProxyManagerTestAsset\BaseInterface" cannot be proxied',
            InvalidProxiedClassException::interfaceNotSupported(
                new ReflectionClass(BaseInterface::class)
            )->getMessage()
        );
    }

    public function testFinalClassNotSupported() : void
    {
        self::assertSame(
            'Provided class "ProxyManagerTestAsset\FinalClass" is final and cannot be proxied',
            InvalidProxiedClassException::finalClassNotSupported(
                new ReflectionClass(FinalClass::class)
            )->getMessage()
        );
    }

    public function testAbstractProtectedMethodsNotSupported() : void
    {
        self::assertSame(
            'Provided class "ProxyManagerTestAsset\ClassWithAbstractProtectedMethod" has following protected abstract'
            . ' methods, and therefore cannot be proxied:' . "\n"
            . 'ProxyManagerTestAsset\ClassWithAbstractProtectedMethod::protectedAbstractMethod',
            InvalidProxiedClassException::abstractProtectedMethodsNotSupported(
                new ReflectionClass(ClassWithAbstractProtectedMethod::class)
            )->getMessage()
        );
    }

    public function testProtectedMethodsNotSupported() : void
    {
        self::assertSame(
            'Provided class "ProxyManagerTestAsset\ClassWithProtectedMethod" has following protected abstract'
            . ' methods, and therefore cannot be proxied:' . "\n",
            InvalidProxiedClassException::abstractProtectedMethodsNotSupported(
                new ReflectionClass(ClassWithProtectedMethod::class)
            )->getMessage()
        );
    }

    public function testAbstractPublicMethodsNotSupported() : void
    {
        self::assertSame(
            'Provided class "ProxyManagerTestAsset\ClassWithAbstractPublicMethod" has following protected abstract'
            . ' methods, and therefore cannot be proxied:' . "\n",
            InvalidProxiedClassException::abstractProtectedMethodsNotSupported(
                new ReflectionClass(ClassWithAbstractPublicMethod::class)
            )->getMessage()
        );
    }
}
