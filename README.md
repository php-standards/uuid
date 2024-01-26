# UUID (Universally Unique Identifier) interface

## Installation

```
composer require psi/uuid
```

## Specification

**Status:** DRAFT

## The UuidGeneratorInterface

#### Purpose

The `UuidGeneratorInterface` interface provides a standardized method to generate UUIDs. 
It abstracts the implementation details of UUID generation, 
allowing different strategies to be used interchangeably.

#### Interface Definition

```php
<?php

namespace Psr\Uuid;

interface UuidGeneratorInterface
{
    public function create(): string;
}

```

#### Method Specification

* **create()**

  * **Description:** Generates a new UUID. The method should ensure that each UUID generated 
  is unique to a very high probability.
  The format and version of the UUID should align with standard UUID conventions (such as Version 1, 3, 4, or 5).
  * **Returns:** A string representing the UUID. This string should conform to the standard UUID format, 
  e.g., 123e4567-e89b-12d3-a456-426614174000.
  * **Exceptions/Errors:** While typically UUID generation is straightforward, 
  implementations should consider handling any errors that could occur during the process 
  (such as cryptographic failures in secure UUID versions) and respond accordingly, 
  potentially throwing exceptions.

**Implementation Notes**

* Implementors of this interface can choose the specific UUID version and generation strategy (e.g., based on random numbers, hashing, time-based, etc.).
* The UUIDs generated should ideally be [RFC 4122](https://datatracker.ietf.org/doc/html/rfc4122) compliant.
* It's important to consider the environment in which the UUIDs are generated to ensure sufficient entropy and uniqueness.

**Usage Example**

```php
<?php

namespace Acme;

use Psr\Uuid\UuidGeneratorInterface;

final class MyUuiGenerator implements UuidGeneratorInterface
{
    public function create(): string
    {
        // Example implementation using random bytes
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

// Usage
$uuidGenerator = new MyUuiGenerator();
$uuid = $uuidGenerator->create();

echo $uuid;

```

**Additional Considerations**

* In a distributed system, ensure that the UUID generation method is 
robust enough to maintain uniqueness across different machines and instances.
* Security considerations might be relevant for certain applications, 
especially when using UUIDs in sensitive contexts. 
For instance, UUIDs should not be predictable for security-critical applications.
* Performance considerations may also be relevant, especially if UUIDs are 
generated at a high frequency.