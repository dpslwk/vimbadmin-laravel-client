<?php

namespace LWK\ViMbAdmin\Model;

use LWK\ViMbAdmin\Model\Link;
use LWK\ViMbAdmin\Model\Alias;
use LWK\ViMbAdmin\Model\Mailbox;
use LWK\ViMBAdmin\Model\Relation;

class Domain implements \JsonSerializable
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
    protected $domain;

    /**
     * @var LWK\ViMBAdmin\Model\Link
     */
    protected $links;

    /**
     * @var array|null
     */
    protected $relationships;

    /**
     * @var array|null
     */
    protected $mailboxes;

    /**
     * @var array|null
     */
    protected $aliases;

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
     * Gets the value of domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the value of domain.
     *
     * @param string $domain the domain
     *
     * @return self
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

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
     * Gets the value of relationships.
     *
     * @return array|null
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * Sets the value of relationships.
     *
     * @param array|null $relationships the relationships
     *
     * @return self
     */
    public function setRelationships($relationships)
    {
        $this->relationships = $relationships;

        return $this;
    }

    /**
     * Add a relationship
     *
     * @param LWK\ViMbAdmin\Model\Relation $realtion a relation
     *
     * @return self
     */
    public function addRelation(Relation $relation)
    {
        $this->relationships[] = $relation;

        return $this;
    }

    /**
     * Gets the value of mailboxes.
     *
     * @return array|null
     */
    public function getMailboxes()
    {
        return $this->mailboxes;
    }

    /**
     * Sets the value of mailboxes.
     *
     * @param array|null $mailboxes the mailboxes
     *
     * @return self
     */
    public function setMailboxes($mailboxes)
    {
        $this->mailboxes = $mailboxes;

        return $this;
    }

    /**
     * Add a mailbox
     *
     * @param LWK\ViMbAdmin\Model\Mailbox $mailbox a mailbox
     *
     * @return self
     */
    public function addMailbox(Mailbox $mailbox)
    {
        $this->mailboxes[] = $mailbox;

        return $this;
    }

    /**
     * Gets the value of aliases.
     *
     * @return array|null
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Sets the value of aliases.
     *
     * @param array|null $aliases the aliases
     *
     * @return self
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;

        return $this;
    }

    /**
     * Add an alias
     *
     * @param LWK\ViMbAdmin\Model\Alias $alias a alias
     *
     * @return self
     */
    public function addalias(Alias $alias)
    {
        $this->aliases[] = $alias;

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
                    'domain' => $this->domain,
                ],
            ],
        ];
    }
}
