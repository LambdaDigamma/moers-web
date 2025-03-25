<?php

namespace Tests\Unit\Hideable;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HideableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('hideable_models');
        Schema::dropIfExists('regular_models');

        Schema::create('hideable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('hidden_at', 0)->nullable();
        });

        Schema::create('regular_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    #[Test]
    public function a_model_can_be_hidden()
    {
        $model = HideableModel::factory()->create();

        $this->assertNull($model->fresh()->hidden_at);

        $model->hide();

        $this->assertNotNull($model->fresh()->hidden_at);
    }

    #[Test]
    public function a_model_can_be_showed()
    {
        $model = HideableModel::factory()->hidden()->create();

        $this->assertNotNull($model->fresh()->hidden_at);

        $model->show();

        $this->assertNull($model->fresh()->hidden_at);
    }

    #[Test]
    public function a_model_cannot_be_queried_normally_when_hidden()
    {
        HideableModel::factory()->hidden()->create();

        HideableModel::factory()->create();

        $this->assertDatabaseCount('hideable_models', 2);

        $this->assertCount(1, HideableModel::all());
    }

    #[Test]
    public function all_models_can_be_found_with_the_with_archived_scope()
    {
        HideableModel::factory()->hidden()->create();
        HideableModel::factory()->create();

        $this->assertCount(2, HideableModel::withHidden()->get());
    }

    #[Test]
    public function only_hidden_models_can_be_found_with_the_only_hidden_scope()
    {
        HideableModel::factory()->hidden()->create();
        HideableModel::factory()->create();

        $this->assertCount(1, HideableModel::onlyHidden()->get());
    }

    #[Test]
    public function models_without_the_hideable_trait_are_not_scoped()
    {
        RegularModel::factory()->create();

        $this->assertCount(1, RegularModel::all());
    }
}
