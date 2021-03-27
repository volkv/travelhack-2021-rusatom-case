<?php


namespace App\Models\Lists;


use App\Models\AbstractModel;

/**
 * Class Lists
 * @package App\Models\Lists
 */
class Lists extends AbstractModel
{
    /**
     * @var string
     */
    protected string $prefix = 'list_';

    /**
     * Get the prefix associated with the model.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return is_null($this->prefix) ? '' : $this->prefix;
    }

    /**
     * Set the prefix associated with the model.
     *
     * @param  string $prefix
     * @return $this
     */
    public function setPrefix($prefix): Lists
    {
        $this->prefix = $prefix;

        return $this;
    }
}
