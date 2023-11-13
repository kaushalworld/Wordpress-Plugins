<?php


namespace Brizy;

class GlobalBlockRulesContext extends Context
{

    /**
     * @var array
     */
    private $collectionTypes;

    /**
     * GlobalBlockRulesContext constructor.
     *
     * @param $data
     * @param array $collectionTypes
     * @throws \Exception
     * @package $collectionTypes
     */
    public function __construct($data, array $collectionTypes)
    {
        if (!is_object($data))
            throw new \Exception('$data invalid argument type. Object expected.');

        if (!is_array($collectionTypes))
            throw new \Exception('$collectionTypes invalid argument type. Array expected.');

        $this->collectionTypes = $collectionTypes;
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function getCollectionTypes()
    {
        return $this->collectionTypes;
    }
}
