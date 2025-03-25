<?php

namespace App\Traits;

use App\Scopes\HideableScope;
use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static static|Builder|\Illuminate\Database\Query\Builder withArchived()
 * @method static static|Builder|\Illuminate\Database\Query\Builder onlyArchived()
 * @method static static|Builder|\Illuminate\Database\Query\Builder withoutArchived()
 */
trait Hideable
{
    /**
     * Indicates if the model should use archives.
     */
    public bool $hides = true;

    /**
     * Boot the archiving trait for a model.
     *
     * @return void
     */
    public static function bootHideable(): void
    {
        static::addGlobalScope(new HideableScope);
    }

    /**
     * Initialize the soft deleting trait for an instance.
     *
     * @return void
     */
    public function initializeHideable(): void
    {
        if (! isset($this->casts[$this->getHiddenAtColumn()])) {
            $this->casts[$this->getHiddenAtColumn()] = 'datetime';
        }
    }

    /**
     * Hide the model.
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function hide(): ?bool
    {
        $this->mergeAttributesFromClassCasts();

        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        // If the model doesn't exist, there is nothing to hide.
        if (! $this->exists) {
            return true;
        }

        // If the hiding event doesn't return false, we'll continue
        // with the operation.
        if ($this->fireModelEvent('hiding') === false) {
            return false;
        }

        // Update the timestamps for each of the models owners. Breaking any caching
        // on the parents
        $this->touchOwners();

        $this->runHide();

        // Fire hidden event to allow hooking into the post-hidden operations.
        $this->fireModelEvent('hidden', false);

        // Return true as the hiding is presumably successful.
        return true;
    }

    /**
     * Perform the actual hiding query on this model instance.
     *
     * @return void
     */
    public function runHide()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getHiddenAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getHiddenAtColumn()} = $time;

        if ($this->usesTimestamps() && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));
    }

    public function show(): bool
    {
        // If the hiding event returns false, we will exit the operation.
        // Otherwise, we will clear the hidden_at timestamp and continue
        // with the operation
        if ($this->fireModelEvent('showing') === false) {
            return false;
        }

        $this->{$this->getHiddenAtColumn()} = null;

        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('showing', false);

        return $result;
    }

    /**
     * Determine if the model instance has been hidden.
     *
     * @return bool
     */
    public function isHidden()
    {
        return ! is_null($this->{$this->getHiddenAtColumn()});
    }

    /**
     * Register a "hiding" model event callback with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function hiding($callback)
    {
        static::registerModelEvent('hiding', $callback);
    }

    /**
     * Register a "hidden" model event callback with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function hidden($callback)
    {
        static::registerModelEvent('hidden', $callback);
    }

    /**
     * Register a "showing" model event callback with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function showing($callback)
    {
        static::registerModelEvent('showing', $callback);
    }

    /**
     * Register a "show" model event callback with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function showed($callback)
    {
        static::registerModelEvent('showed', $callback);
    }

    /**
     * Get the name of the "hidden at" column.
     *
     * @return string
     */
    public function getHiddenAtColumn()
    {
        return defined('static::HIDDEN_AT') ? static::HIDDEN_AT : 'hidden_at';
    }

    /**
     * Get the fully qualified "hidden at" column.
     *
     * @return string
     */
    public function getQualifiedHiddenAtColumn()
    {
        return $this->qualifyColumn($this->getHiddenAtColumn());
    }
}
