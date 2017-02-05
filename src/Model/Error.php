<?php

namespace LWK\ViMbAdmin\Model;

class Error implements \JsonSerializable
{
    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @var array
     */
    protected $meta;

    /**
     * Gets the value of status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the value of status.
     *
     * @param int $status the status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param string $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the value of detail.
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Sets the value of detail.
     *
     * @param string $detail the detail
     *
     * @return self
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Gets the value of meta.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Sets the value of meta.
     *
     * @param array $meta the meta
     *
     * @return self
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;

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
