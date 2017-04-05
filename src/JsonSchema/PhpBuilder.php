<?php

namespace Swaggest\PhpCodeBuilder\JsonSchema;

use Swaggest\JsonSchema\Schema;
use Swaggest\PhpCodeBuilder\PhpAnyType;
use Swaggest\PhpCodeBuilder\PhpClass;
use Swaggest\PhpCodeBuilder\PhpClassProperty;
use Swaggest\PhpCodeBuilder\PhpFlags;
use Swaggest\PhpCodeBuilder\PhpFunction;
use Swaggest\PhpCodeBuilder\PhpNamedVar;
use Swaggest\PhpCodeBuilder\PhpCode;
use Swaggest\PhpCodeBuilder\Property\Getter;
use Swaggest\PhpCodeBuilder\Property\Setter;

class PhpBuilder
{
    /** @var \SplObjectStorage|GeneratedClass[] */
    private $generatedClasses;
    private $untitledIndex = 0;

    public function __construct()
    {
        $this->generatedClasses = new \SplObjectStorage();
    }

    /**
     * @param Schema $schema
     * @param string $path
     * @return PhpAnyType
     */
    public function getType(Schema $schema, $path = '#')
    {
        $typeBuilder = new TypeBuilder($schema, $path, $this);
        return $typeBuilder->build();
    }


    public function getClass(Schema $schema, $path)
    {
        if ($this->generatedClasses->contains($schema)) {
            return $this->generatedClasses[$schema]->class;
        } else {
            return $this->makeClass($schema, $path)->class;
        }
    }

    private function makeClass(Schema $schema, $path)
    {
        $generatedClass = new GeneratedClass();
        $generatedClass->schema = $schema;

        $class = new PhpClass();
        $class->setName('Untitled' . ++$this->untitledIndex);
        $class->setExtends(Palette::classStructureClass());


        $setupProperties = new PhpFunction('setUpProperties');
        $setupProperties
            ->setVisibility(PhpFlags::VIS_PUBLIC)
            ->setIsStatic(true);
        $setupProperties
            ->addArgument(new PhpNamedVar('properties', Palette::propertiesOrStaticClass()))
            ->addArgument(new PhpNamedVar('ownerSchema', Palette::schemaClass()));

        $body = new PhpCode();

        $class->addMethod($setupProperties);

        $generatedClass->class = $class;
        $generatedClass->path = $path;

        $this->generatedClasses->attach($schema, $generatedClass);

        $schemaBuilder = new SchemaBuilder();

        foreach ($schema->properties->toArray() as $name => $property) {
            $phpProperty = new PhpClassProperty($name, $this->getType($property, $path . '->' . $name));
            $class->addProperty($phpProperty);
            $class->addMethod(new Getter($phpProperty));
            $class->addMethod(new Setter($phpProperty));
            $body->addSnippet(
                $schemaBuilder->build($property, '$properties->' . $name)
            );
        }

        $setupProperties->setBody($body);

        return $generatedClass;
    }

    /**
     * @return GeneratedClass[]
     */
    public function getGeneratedClasses()
    {
        $result = array();
        foreach ($this->generatedClasses as $schema) {
            $result[] = $this->generatedClasses[$schema];
        }
        return $result;
    }

}