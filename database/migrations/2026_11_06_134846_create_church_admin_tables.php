<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->after('email'); // null = no admin access
        });

        // --- Website content (edited in /admin) ---
        Schema::create('service_times', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('time');
            $table->string('name');
            $table->string('icon')->default('sun');
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('summary');
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->string('time')->nullable();
            $table->text('summary')->nullable();
            $table->string('image')->nullable();
            $table->boolean('image_is_poster')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('preacher')->nullable();
            $table->date('preached_on');
            $table->string('video_url');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
        });

        // --- People ---
        Schema::create('home_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('area');
            $table->string('meeting_day')->default('Tuesday');
            $table->string('meeting_time')->default('18:00');
            $table->foreignId('leader_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('birthday')->nullable();
            $table->string('area')->nullable();
            $table->string('status')->default('member'); // visitor | member | past_member
            $table->date('joined_on')->nullable();
            $table->foreignId('home_group_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('consent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('connect_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('area')->nullable();
            $table->date('visited_on')->nullable();
            $table->string('how_heard')->nullable();
            $table->json('interests')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('consent_at');
            $table->string('status')->default('new'); // new | contacted | added
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('prayer_requests', function (Blueprint $table) {
            $table->string('status')->default('new'); // new | prayed | followed_up
            $table->timestamp('consent_at')->nullable();
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('prayer_requests', fn (Blueprint $t) => $t->dropColumn(['status', 'consent_at', 'notes']));
        Schema::dropIfExists('connect_cards');
        Schema::dropIfExists('members');
        Schema::dropIfExists('home_groups');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('sermons');
        Schema::dropIfExists('events');
        Schema::dropIfExists('ministries');
        Schema::dropIfExists('service_times');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('role'));
    }
};
