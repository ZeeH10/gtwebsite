<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Filament\Imports\MemberImporter;
use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Models\HomeGroup;
use App\Models\Member;
use App\Models\PrayerRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private function user(?Role $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    public function test_guests_are_sent_to_login_and_users_without_a_role_are_refused(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->actingAs($this->user(null))->get('/admin')->assertForbidden();
    }

    public function test_pages_open_for_the_right_roles_only(): void
    {
        $this->actingAs($this->user(Role::SuperAdmin))->get('/admin')->assertOk();

        $media = $this->user(Role::Media);
        $this->actingAs($media)->get('/admin/events')->assertOk();
        $this->actingAs($media)->get('/admin/prayer-requests')->assertForbidden();
        $this->actingAs($media)->get('/admin/members')->assertForbidden();
        $this->actingAs($media)->get('/admin/users')->assertForbidden();

        $this->actingAs($this->user(Role::Admin))->get('/admin/users')->assertForbidden();
        $this->actingAs($this->user(Role::Pastor))->get('/admin/prayer-requests')->assertOk();
    }

    public function test_pastors_only_prayers_are_hidden_from_everyone_but_pastors(): void
    {
        PrayerRequest::create(['request' => 'open request', 'pastors_only' => false]);
        PrayerRequest::create(['request' => 'confidential request', 'pastors_only' => true]);

        foreach ([Role::Admin, Role::SuperAdmin] as $role) {
            $this->actingAs($this->user($role));
            $this->assertSame(['open request'], PrayerRequestResource::getEloquentQuery()->pluck('request')->all());
        }

        $this->actingAs($this->user(Role::Pastor));
        $this->assertSame(2, PrayerRequestResource::getEloquentQuery()->count());
    }

    public function test_home_group_leaders_only_see_their_own_group(): void
    {
        $leader = $this->user(Role::GroupLeader);
        $mine = HomeGroup::create(['name' => 'Mine', 'area' => 'North End', 'leader_user_id' => $leader->id]);
        $other = HomeGroup::create(['name' => 'Other', 'area' => 'Walmer']);
        Member::create(['first_name' => 'In', 'home_group_id' => $mine->id]);
        Member::create(['first_name' => 'Out', 'home_group_id' => $other->id]);
        Member::create(['first_name' => 'Nobody']);

        $this->actingAs($leader);
        $this->assertSame(['In'], MemberResource::getEloquentQuery()->pluck('first_name')->all());

        $this->actingAs($this->user(Role::Admin));
        $this->assertSame(3, MemberResource::getEloquentQuery()->count());
    }

    public function test_spreadsheet_import_maps_rows_and_updates_existing_people(): void
    {
        $group = HomeGroup::create(['name' => 'North End group', 'area' => 'North End']);
        Member::create(['first_name' => 'Old', 'phone' => '0821112222']);

        $this->actingAs($this->user(Role::Admin));
        $columns = ['first_name' => 'Name', 'last_name' => 'Surname', 'phone' => 'Cell', 'status' => 'Status', 'homeGroup' => 'Group'];

        MemberImporter::test($columns)->import(['Name' => 'Rudo', 'Surname' => 'Moyo', 'Cell' => '0830000000', 'Status' => 'Past', 'Group' => 'North End group'])->assertImported();
        MemberImporter::test($columns)->import(['Name' => 'Updated', 'Surname' => '', 'Cell' => '0821112222', 'Status' => '', 'Group' => ''])->assertImported();

        $rudo = Member::where('first_name', 'Rudo')->sole();
        $this->assertSame('past_member', $rudo->status);
        $this->assertTrue($rudo->homeGroup->is($group));
        $this->assertSame(2, Member::count()); // second row updated the existing person by phone
        $this->assertSame('member', Member::where('phone', '0821112222')->value('status'));
    }
}
