<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // ── AUTHENTICATION GUARD TESTS ──────────────────────────────────

    public function test_guests_cannot_access_tasks(): void
    {
        $this->get(route('tasks.index'))->assertRedirect(route('login'));
        $this->get(route('tasks.create'))->assertRedirect(route('login'));
    }

    // ── INDEX ────────────────────────────────────────────────────────

    public function test_user_can_view_their_tasks(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    public function test_user_cannot_see_other_users_tasks(): void
    {
        $otherUser = User::factory()->create();
        $otherTask = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertDontSee($otherTask->title);
    }

    // ── CREATE ───────────────────────────────────────────────────────

    public function test_user_can_create_a_task(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title'       => 'Test Task',
            'description' => 'A test description',
            'status'      => 'pending',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title'   => 'Test Task',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_task_title_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title'  => '',
            'status' => 'pending',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_task_status_must_be_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title'  => 'A Task',
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    // ── SHOW ─────────────────────────────────────────────────────────

    public function test_user_can_view_their_own_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('tasks.show', $task));

        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    public function test_user_cannot_view_another_users_task(): void
    {
        $otherUser = User::factory()->create();
        $task      = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('tasks.show', $task));

        $response->assertStatus(403);
    }

    // ── UPDATE ───────────────────────────────────────────────────────

    public function test_user_can_update_their_task(): void
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title'   => 'Old Title',
        ]);

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title'  => 'Updated Title',
            'status' => 'done',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title', 'status' => 'done']);
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $otherUser = User::factory()->create();
        $task      = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title'  => 'Hacked Title',
            'status' => 'done',
        ]);

        $response->assertStatus(403);
    }

    // ── DELETE ───────────────────────────────────────────────────────

    public function test_user_can_delete_their_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_delete_another_users_task(): void
    {
        $otherUser = User::factory()->create();
        $task      = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    // ── TOGGLE ───────────────────────────────────────────────────────

    public function test_user_can_toggle_task_status(): void
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'status'  => 'pending',
        ]);

        $this->actingAs($this->user)->patch(route('tasks.toggle', $task));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done']);
    }

    public function test_user_cannot_toggle_another_users_task(): void
    {
        $otherUser = User::factory()->create();
        $task      = Task::factory()->create(['user_id' => $otherUser->id, 'status' => 'pending']);

        $response = $this->actingAs($this->user)->patch(route('tasks.toggle', $task));

        $response->assertStatus(403);
    }
}
