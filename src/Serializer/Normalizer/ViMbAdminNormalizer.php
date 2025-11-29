<?php

namespace LWK\ViMbAdmin\Serializer\Normalizer;

use Illuminate\Support\Str;
use LWK\ViMbAdmin\Model\Error;
use LWK\ViMbAdmin\Model\Link;
use LWK\ViMbAdmin\Model\Relation;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ViMbAdminNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object      $object  object to normalize
     * @param string|null $format  format the normalization result will be encoded as
     * @param array       $context Context options for the normalizer
     *
     * @return array|scalar
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        // TODO: ???
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed       $data   Data to normalize
     * @param string|null $format The format being (de-)serialized from or into
     * @param array       $context Context options for the normalizer
     *
     * @return bool
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        // TODO: ???
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed       $data    data to restore
     * @param string      $class   the expected class to instantiate
     * @param string|null $format  format the given data was extracted from
     * @param array       $context options available to the denormalizer
     *
     * @return object
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $normalizedData = (array) $data; // not sure i need this yet
        // default to an array object
        $object = [];

        if (! isset($context['first_pass'])) {
            $context['first_pass'] = true;
            if (count($normalizedData) == 1 && array_key_exists('links', $normalizedData)) {
                // this must be link response to a post/patch request
                $link = new Link();
                foreach ($normalizedData['links'] as $key => $_value) {
                    try {
                        $this->propertyAccessor->setValue($link, $key, $_value);
                    } catch (NoSuchPropertyException $exception) {
                        // Properties not found are ignored
                    }
                }

                return $link;
            }
            // do we have an 'included' key?
            // if so recursive each include and add to context so they can be added with later relationships?
            //  set $context['processing_includes'] while doing this
            if (isset($normalizedData['included'])) {
                $context['processing_includes'] = true;
                foreach ($normalizedData['included'] as $include) {
                    $singleType = Str::ucfirst(Str::singular($include['type']));
                    $includelCass = 'LWK\ViMbAdmin\Model\\' . $singleType;
                    $includeObject = $this->denormalize($include, $includelCass, $format, $context);
                    $context[$includeObject->getType()][$includeObject->getId()] = $includeObject;
                }
                unset($context['processing_includes']);
            }
            // is this a singluar data object
            if (isset($normalizedData['data']['type'])) {
                $normalizedData = $normalizedData['data'];
            }
        }

        if (array_key_exists('type', $normalizedData)) {
            $singleType = Str::ucfirst(Str::singular($normalizedData['type']));
            $class = 'LWK\ViMbAdmin\Model\\' . $singleType;
            $reflectionClass = new \ReflectionClass($class);
            $object = $reflectionClass->newInstanceArgs();
        }

        foreach ($normalizedData as $attribute => $value) {
            switch ($attribute) {
                case 'data':
                    // if this is an arrary of objects we need to foreach recursive call, if not just recursive call???
                    foreach ($value as $data) {
                        $singleType = Str::ucfirst(Str::singular($data['type']));
                        $class = 'LWK\ViMbAdmin\Model\\' . $singleType;
                        $object[] = $this->denormalize($data, $class, $format, $context);
                    }
                    break;
                case 'attributes':
                    foreach ($value as $key => $_value) {
                        try {
                            $this->propertyAccessor->setValue($object, $key, $_value);
                        } catch (NoSuchPropertyException $exception) {
                            // Properties not found are ignored
                        }
                    }
                    break;
                case 'type':
                    try {
                        $this->propertyAccessor->setValue($object, $attribute, $value);
                    } catch (NoSuchPropertyException $exception) {
                        // Properties not found are ignored
                    }
                    break;
                case 'id':
                    try {
                        $this->propertyAccessor->setValue($object, $attribute, $value);
                    } catch (NoSuchPropertyException $exception) {
                        // Properties not found are ignored
                    }
                    break;
                case 'links':
                    // create a new Link object and add it to the $object if its not an array object
                    if (! $object) {
                        break;
                    }
                    $link = new Link();
                    foreach ($value as $key => $_value) {
                        try {
                            $this->propertyAccessor->setValue($link, $key, $_value);
                        } catch (NoSuchPropertyException $exception) {
                            // Properties not found are ignored
                        }
                    }

                    try {
                        $this->propertyAccessor->setValue($object, $attribute, $link);
                    } catch (NoSuchPropertyException $exception) {
                        // Properties not found are ignored
                    }
                    break;
                case 'relationships':
                    if (isset($context['processing_includes'])) {
                        // we dont porcess relations on includes
                        break;
                    }
                    // foreach type of relation,
                    //     foreach relation
                    //         see if we have this in the includes context if so add it to the $object
                    //         also make Relation object and add to the $object?
                    foreach ($value as $type => $relations) {
                        if (isset($relations['data']['type'])) {
                            $relationships = [$relations['data']];
                        } elseif (isset($relations['data'])) {
                            $relationships = $relations['data'];
                        } else {
                            break;
                        }
                        // if (! $relationships) {
                        //     break;
                        // }

                        foreach ($relationships as $relation) {
                            $relationObject = new Relation();
                            $relationObject->setid($relation['id']);
                            $relationObject->setType($relation['type']);

                            switch ($type) {
                                case 'domain':
                                    $object->setRelation($relationObject);
                                    if (isset($context['domains'])) {
                                        $object->setDomain($context['domains'][$relation['id']]);
                                    }
                                    break;
                                case 'mailboxes':
                                    $object->addRelation($relationObject);
                                    if (isset($context[$type])) {
                                        $object->addMailbox($context[$type][$relation['id']]);
                                    }
                                    break;
                                case 'aliases':
                                    $object->addRelation($relationObject);
                                    if (isset($context[$type])) {
                                        $object->addAlias($context[$type][$relation['id']]);
                                    }
                                    break;

                                default:
                                    // code...
                                    break;
                            }
                        }
                    }
                    break;
                case 'errors':
                    // errors is an array, work through each elemnet creating new Error boject and append to $object['errors'][]
                    foreach ($value as $errorArray) {
                        $error = new Error();
                        foreach ($errorArray as $key => $_value) {
                            try {
                                $this->propertyAccessor->setValue($error, $key, $_value);
                            } catch (NoSuchPropertyException $exception) {
                                // Properties not found are ignored
                            }
                        }
                        $object['errors'][] = $error;
                    }
                    break;

                default:
                    // code...
                    break;
            }
        }

        return $object;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed       $data   Data to denormalize from
     * @param string      $type   The class to which the data should be denormalized
     * @param string|null $format The format being deserialized from
     * @param array       $context options available to the denormalizer
     *
     * @return bool
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_array($data);
    }
}
