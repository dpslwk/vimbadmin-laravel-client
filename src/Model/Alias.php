<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMbAdmin\Model\Link;
use LWK\ViMBAdmin\Model\Relation;

class Alias implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var array
     */
    protected $goto;

    /**
     * @var LWK\ViMBAdmin\Model\Link
     */
    protected $links;

    /**
     * @var LWK\ViMBAdmin\Model\Relation
     */
    protected $relation;

    /**
     * @var LWK\ViMbAdmin\Model\Domain|null
     */
    protected $domain;

    /**
     * create a new Alias
     * @param  string $address
     * @param  array $goto
     * @param  Domain $domain
     * @return Alias
     */
    static public function create(string $address, array $goto, Domain $domain)
    {
        $_alias = new static();
        $_alias->type = 'aliases';
        $_alias->address = $address;
        $_alias->goto = $goto;
        $_alias->domain = $domain;
        return $_alias;
    }

    /**
     * Gets the value of type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the value of type.
     *
     * @param string $type the type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets the value of id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the value of address.
     *
     * @param string $address the address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets the value of goto.
     *
     * @return array
     */
    public function getGoto()
    {
        return $this->goto;
    }

    /**
     * Sets the value of goto.
     *
     * @param array $goto the goto
     *
     * @return self
     */
    public function setGoto(array $goto)
    {
        $this->goto = $goto;

        return $this;
    }

    /**
     * Add one address to the forward.
     * @param string $address email address to add
     */
    public function addForwardAddress(string $address)
    {
        if (! in_array($address, $this->goto)) {
            $this->goto[] = $address;
        }

        return $this;
    }

    /**
     * Remove one address form the forward.
     * @param string $address email address to add
     */
    public function removeForwardAddress(string $address)
    {
        if (($key = array_search($address, $this->goto)) !== false) {
            unset($this->goto[$key]);
        }

        return $this;
    }

    /**
     * Gets the value of links.
     *
     * @return LWK\ViMBAdmin\Model\Link
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Sets the value of links.
     *
     * @param LWK\ViMBAdmin\Model\Link $links the links
     *
     * @return self
     */
    public function setLinks(Link $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Gets the value of relation.
     *
     * @return LWK\ViMBAdmin\Model\Relation
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Sets the value of relation.
     *
     * @param LWK\ViMBAdmin\Model\Relation $relation the relation
     *
     * @return self
     */
    public function setRelation(Relation $relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Gets the value of domain.
     *
     * @return LWK\ViMbAdmin\Model\Domain|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the value of domain.
     *
     * @param LWK\ViMbAdmin\Model\Domain|null $domain the domain
     *
     * @return self
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * jsonSerializer used to pass back to API
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'data' => [
                'type' => $this->type,
                'id'      => $this->id,
                'attributes' => [
                    'address' => $this->address,
                    'goto'    => $this->goto,
                ],
            ],
        ];
    }
}
