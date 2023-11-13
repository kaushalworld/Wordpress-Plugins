<?php

namespace Brizy;

/**
 * Class GlobalBlockRulesTransformer
 * @package Brizy
 */
class GlobalBlockRulesTransformer implements DataTransformerInterface
{
    /**
     * @param ContextInterface $context
     *
     * @return void
     * @throws \Exception
     */
    public function execute(ContextInterface $context)
    {
        /**
         * @var GlobalBlockRulesContext $context ;
         */

        $data = $context->getData();
        $collectionTypes = $context->getCollectionTypes();

        $context->setData($this->migrateRules($data, $collectionTypes));
    }

    /**
     * @param $globalBlock
     * @param $collectionType
     * @return object
     * @throws \Exception
     */
    public function migrateRules($globalBlock, $collectionTypes)
    {
        $newGlobalBlock = $globalBlock;

        if (!isset($globalBlock->rules)) {
            throw new \Exception("Missing Rules in Global Blocks");
        }

        $newRules = [];

        foreach ($globalBlock->rules as $rule) {
            if (!is_object($rule)) {
                throw new \Exception('Rule invalid type. Object expected.');
            }

            if ($this->isItemRule($rule)) {
                $newRule = $rule;
                $entityType = $rule->entityType;
                $entityValues = $rule->entityValues;

                $collectionType = $this->find($collectionTypes, function ($type) use ($entityType) {
                    return $type->id === $entityType;
                });

                // Skip Rule because the rule contain collectionType id
                // with doesn't exist in the BD
                if (!$collectionType) {
                    continue;
                }

                if (isset($collectionType->fields)) {
                    $fieldsEntityValues = array_unique(array_reduce($collectionType->fields, function ($acc, $field) {
                        $fieldId = $field->id;
                        $entityValue = array_map(function ($itemId) use ($fieldId) {
                            return $fieldId . "|||" . $itemId;
                        }, $field->entityValues);

                        return array_merge($acc, $entityValue);
                    }, []));

                    foreach ($entityValues as $itemId) {
                        $found = array_unique(array_filter($fieldsEntityValues, function ($field) use ($itemId) {
                            list($_, $collectionId) = explode("|||", $field);
                            return $collectionId === $itemId;
                        }));

                        switch (count($found)) {
                            case 0:
                            {
                                $newRules[] = (object)array_merge((array)$newRule, [
                                    "mode" => "specific",
                                    "entityValues" => [$itemId]
                                ]);
                                break;
                            }
                            case 1:
                            {
                                list ($fieldId) = explode("|||", array_values($found)[0]);
                                $newRules[] = (object)array_merge((array)$newRule, [
                                    "mode" => "reference",
                                    "entityValues" => [$fieldId . ":" . $itemId]
                                ]);
                                break;
                            }
                            default:
                            {
                                foreach ($found as $rule) {
                                    list ($fieldId) = explode("|||", $rule);
                                    $newRules[] = (object)array_merge((array)$newRule, [
                                        "mode" => "reference",
                                        "entityValues" => [$fieldId . ":" . $itemId]
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    throw new \Exception('fields invalid type. Array expected.');
                }
            } else {
                $newRules[] = $rule;
            }
        }

        $globalBlock->rules = $newRules;

        return $newGlobalBlock;
    }

    /**
     * @param $rule
     * @return bool
     */
    public function isItemRule($rule)
    {
        if (isset($rule->entityValues)) {
            return count($rule->entityValues) > 0;
        }

        return false;
    }

    /**
     * @param $collection
     * @param $cb
     * @return bool
     */
    private function find($collection, $cb)
    {
        return array_reduce($collection, function ($found, $item) use ($cb) {
            if ($cb($item)) {
                return $item;
            }

            return $found;
        });
    }
}


