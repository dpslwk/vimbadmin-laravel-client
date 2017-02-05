<?php

namespace LWK\ViMbAdmin\Model;

class Link implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $self;

    /**
     * @var string
     */
    protected $related;

    /**
     * Gets the value of self.
     *
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     * Sets the value of self.
     *
     * @param string $self the self
     *
     * @return self
     */
    public function setSelf($self)
    {
        $this->self = $self;

        return $this;
    }

    /**
     * Gets the value of related.
     *
     * @return string
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * Sets the value of related.
     *
     * @param string $related the related
     *
     * @return self
     */
    public function setRelated($related)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * jsonSerializer used to pass back to API
     * @return array
     */
    public function jsonSerialize() {
        return [

        ];
    }

}
