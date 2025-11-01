<?php

use App\Model\Trait\Draftable;

class DraftableTraitTest extends TestCase
{
    private $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new class {
            use Draftable;

            public $active = 1;
        };
    }

    /** @test */
    public function it_returns_true_when_active_is_zero()
    {
        $this->model->active = 0;
        $this->assertTrue($this->model->isDraft());
    }

    /** @test */
    public function it_returns_false_when_active_is_one()
    {
        $this->model->active = 1;
        $this->assertFalse($this->model->isDraft());
    }

    /** @test */
    public function it_returns_false_when_active_is_greater_than_one()
    {
        $this->model->active = 2;
        $this->assertFalse($this->model->isDraft());
    }

    /** @test */
    public function it_returns_true_when_active_is_null_and_treated_as_zero()
    {
        $this->model->active = null;
        // == 0 → true (laza egyenlőség)
        $this->assertTrue($this->model->isDraft());
    }

    /** @test */
    public function it_returns_false_when_active_is_string_zero()
    {
        $this->model->active = '0';
        $this->assertTrue($this->model->isDraft()); // mert == 0
    }

    /** @test */
    public function it_returns_false_when_active_is_non_zero_string()
    {
        $this->model->active = '1';
        $this->assertFalse($this->model->isDraft());
    }

    /** @test */
    public function it_returns_false_when_active_is_boolean_true()
    {
        $this->model->active = true;
        $this->assertFalse($this->model->isDraft()); // true == 1 → false
    }

    /** @test */
    public function it_returns_true_when_active_is_boolean_false()
    {
        $this->model->active = false;
        $this->assertTrue($this->model->isDraft()); // false == 0 → true
    }
}