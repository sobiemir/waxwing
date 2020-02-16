<?php

namespace Waxwing\Tags;

use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;

final class CategoryTag extends BaseTag implements StaticMethod
{
    /** @var string */
    protected $name = 'category';
    /** @var string */
    private $categoryName = '';

    public function __construct(string $categoryName)
    {
        $this->categoryName  = $categoryName;
    }

    public function getCategoryName() : string
    {
        return $this->categoryName;
    }

    public function __toString() : string
    {
        return $this->categoryName;
    }

    public static function create($body)
    {
        return new static(trim($body));
    }
}
