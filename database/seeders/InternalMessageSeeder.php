<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InternalMessage;
use Illuminate\Support\Str;

class InternalMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admin and staff users
        $users = User::whereIn('role', ['admin', 'staff'])->get();

        if ($users->count() < 2) {
            $this->command->info('Need at least 2 users (admin/staff) to seed messages.');
            return;
        }

        // Generate 150 dummy messages for testing pagination
        for ($i = 0; $i < 150; $i++) {
            $sender = $users->random();
            $receiver = $users->where('id', '!=', $sender->id)->random();

            InternalMessage::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'subject' => 'Test Message ' . Str::random(5),
                'body' => 'This is a generated test message body. ' . Str::random(50),
                'created_at' => now()->subMinutes(rand(1, 10000)),
                'read_at' => rand(0, 1) ? now() : null, // 50% chance of being read
            ]);
        }
    }
}
