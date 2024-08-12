<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMBAdmin\Model\Relation;

class Mailbox implements \JsonSerializable
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
    protected $username;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $password;

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
     * Create a new Mailbox.
     * @param  string $username
     * @param  string $name
     * @param  Domain $domain
     * @param  string $password
     * @return Mailbox
     */
    public static function create(string $username, string $name, Domain $domain, string $password = null)
    {
        $_mailbox = new static();
        $_mailbox->type = 'mailboxes';
        $_mailbox->username = $username;
        $_mailbox->name = $name;
        $_mailbox->domain = $domain;
        $_mailbox->password = $password;

        return $_mailbox;
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
     * Gets the value of username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the value of username.
     *
     * @param string $username the username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @param LWK\ViMBAdmin\Model\Relation $relation the relations
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
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * jsonSerializer used to pass back to API.
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'data' => [
                'type' => $this->type,
                'id'      => $this->id,
                'attributes' => [
                    'username' => $this->username,
                    'name'     => $this->name,
                    'password' => $this->password,
                ],
            ],
        ];
    }
}
