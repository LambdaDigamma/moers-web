<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HideableScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected array $extensions = ['Hide', 'Show', 'WithHidden', 'WithoutHidden', 'OnlyHidden'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (is_callable([$model, 'getQualifiedHiddenAtColumn'], true, $name)) {
            $builder->whereNull($model->getQualifiedHiddenAtColumn());
        }
    }

    /**
     * Extend the query builder with the needed functions.
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "archived at" column for the builder.
     *
     * @return string
     */
    protected function getHiddenAtColumn(Builder $builder)
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedHiddenAtColumn();
        }

        return $builder->getModel()->getHiddenAtColumn();
    }

    /**
     * Add the hide extension to the builder.
     *
     * @return void
     */
    protected function addHide(Builder $builder)
    {
        $builder->macro('hide', function (Builder $builder) {
            $column = $this->getHiddenAtColumn($builder);

            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }

    /**
     * Add the show extension to the builder.
     *
     * @return void
     */
    protected function addShow(Builder $builder)
    {
        $builder->macro('show', function (Builder $builder) {
            $builder->withHidden();

            $column = $this->getHiddenAtColumn($builder);

            return $builder->update([
                $column => null,
            ]);
        });
    }

    /**
     * Add the with-hidden extension to the builder.
     *
     * @return void
     */
    protected function addWithHidden(Builder $builder)
    {
        $builder->macro('withHidden', function (Builder $builder, $withHidden = true) {
            if (! $withHidden) {
                return $builder->withoutHidden();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-hidden extension to the builder.
     *
     * @return void
     */
    protected function addWithoutHidden(Builder $builder)
    {
        $builder->macro('withoutHidden', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedHiddenAtColumn()
            );
        });
    }

    /**
     * Add the only-hidden extension to the builder.
     *
     * @return void
     */
    protected function addOnlyHidden(Builder $builder)
    {
        $builder->macro('onlyHidden', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedHiddenAtColumn()
            );

            return $builder;
        });
    }
}
