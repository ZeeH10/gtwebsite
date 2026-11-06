<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\ServiceTime;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Moves the starter content from config/church.php into the database (only into empty tables),
 * and creates the first super admin from ADMIN_* values in .env. Safe to run more than once.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $c = config('church');

        // Starter images go onto the public disk so /admin can preview and replace them like uploads.
        foreach (glob(public_path('images/*.{jpg,webp,png}'), GLOB_BRACE) as $file) {
            $path = 'images/'.basename($file);
            Storage::disk('public')->exists($path) || Storage::disk('public')->put($path, file_get_contents($file));
        }

        if (ServiceTime::doesntExist()) {
            foreach ($c['services'] as $i => $s) {
                ServiceTime::create($s + ['sort' => $i]);
            }
        }

        if (Ministry::doesntExist()) {
            foreach ($c['ministries'] as $i => $m) {
                Ministry::create(['name' => $m['name'], 'summary' => $m['text'], 'image' => isset($m['image']) ? 'images/'.$m['image'] : null, 'sort' => $i]);
            }
        }

        if (Event::doesntExist()) {
            foreach ($c['events'] as $e) {
                Event::create([
                    'title' => $e['name'], 'starts_on' => $e['date'], 'ends_on' => $e['end'] ?? null, 'time' => $e['time'],
                    'summary' => $e['text'], 'image' => 'images/'.$e['image'], 'image_is_poster' => $e['poster'] ?? false,
                ]);
            }
        }

        if (($email = env('ADMIN_EMAIL')) && ($password = env('ADMIN_PASSWORD'))) {
            User::firstOrCreate(['email' => $email], [
                'name' => env('ADMIN_NAME', 'Site admin'), 'password' => $password, 'role' => Role::SuperAdmin,
            ]);
        }
    }
}
