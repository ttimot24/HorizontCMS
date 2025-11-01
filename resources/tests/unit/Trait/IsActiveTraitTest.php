<?php

use App\Model\Trait\IsActive;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;

class IsActiveTraitTest extends TestCase
{
    use RefreshDatabase;

    private $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new class extends Model {
            use IsActive;

            protected $table = 'blogposts';
            protected $fillable = ['title','slug', 'author_id', 'comments_enabled' ,'active'];
        };
    }

    /** @test */
    public function activate_sets_active_to_one()
    {
        $this->model->active = 0;
        $this->model->activate();

        $this->assertEquals(1, $this->model->active);
        $this->assertTrue($this->model->isActive());
    }

    /** @test */
    public function deactivate_sets_active_to_zero()
    {
        $this->model->active = 1;
        $this->model->deactivate();

        $this->assertEquals(0, $this->model->active);
        $this->assertTrue($this->model->isInactive());
    }

    /** @test */
    public function is_active_returns_true_when_active_is_greater_than_zero()
    {
        $this->model->active = 1;
        $this->assertTrue($this->model->isActive());

        $this->model->active = 5;
        $this->assertTrue($this->model->isActive());
    }

    /** @test */
    public function is_active_returns_false_when_active_is_zero_or_null()
    {
        $this->model->active = 0;
        $this->assertFalse($this->model->isActive());

        $this->model->active = null;
        $this->assertFalse($this->model->isActive());
    }

    /** @test */
    public function is_inactive_returns_true_only_when_active_is_zero()
    {
        $this->model->active = 0;
        $this->assertTrue($this->model->isInactive());

        $this->model->active = 1;
        $this->assertFalse($this->model->isInactive());

        $this->model->active = null;
        $this->assertTrue($this->model->isInactive());
    }

    /** @test */
    public function scope_active_filters_records_with_active_greater_than_zero()
    {
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug', 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 1]);
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug', 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 0]);
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug', 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 2]);

        $active = $this->model->active()->get();

        $this->assertCount(2, $active);
        $this->assertContains(1, $active->pluck('active')->toArray());
        $this->assertContains(2, $active->pluck('active')->toArray());
    }

    /** @test */
    public function scope_in_active_filters_records_with_active_equal_to_zero()
    {
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug' , 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 0]);
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug' , 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 1]);
        $this->model->newQuery()->create(['title' => 'Test Post', 'slug' => 'slug' , 'comments_enabled' => 1 , 'author_id' => 1, 'active' => 0]);

        $inactive = $this->model->inActive()->get();

        $this->assertCount(2, $inactive);
        $this->assertEquals([0, 0], $inactive->pluck('active')->toArray());
    }

    /** @test */
    public function activate_and_deactivate_can_be_chained()
    {
        $this->model->deactivate();
        $this->model->activate();

        $this->assertEquals(1, $this->model->active);
        $this->assertTrue($this->model->isActive());
    }

    /** @test */
    public function it_handles_string_values_gracefully()
    {
        $this->model->active = '0';
        $this->assertTrue($this->model->isInactive());
        $this->assertFalse($this->model->isActive());

        $this->model->active = '1';
        $this->assertTrue($this->model->isActive());
    }

    /** @test */
    public function it_handles_boolean_values()
    {
        $this->model->active = true;
        $this->assertTrue($this->model->isActive());

        $this->model->active = false;
        $this->assertTrue($this->model->isInactive());
    }
}