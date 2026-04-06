<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\MemberType;
use App\Models\Biblio;
use App\Models\Item;
use App\Models\Loan;
use App\Models\Reservation;
use Carbon\Carbon;

class CirculationSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Member Types exist
        if (MemberType::count() == 0) {
            MemberType::create([
                'member_type_name' => 'Standard Member',
                'loan_limit' => 3,
                'loan_periode' => 7,
                'fine_each_day' => 1000,
                'grace_period' => 0,
                'input_date' => now(),
                'last_update' => now()
            ]);
        }

        // 2. Create Dummy Members
        $members = [
            ['M001', 'John Doe', 'john@example.com'],
            ['M002', 'Jane Smith', 'jane@example.com'],
            ['M003', 'Alice Johnson', 'alice@example.com'],
        ];

        foreach ($members as $m) {
            if (!Member::where('member_id', $m[0])->exists()) {
                Member::create([
                    'member_id' => $m[0],
                    'member_name' => $m[1],
                    'member_email' => $m[2],
                    //'gender' => 1,
                    //'member_type_id' => 1, // Potentially causing FK error if table empty or id diff
                    //'member_status' => 1, // Potentially missing column
                    'mpasswd' => bcrypt('password'),
                    'input_date' => now(),
                    'last_update' => now()
                ]);
            }
        }

        // 3. Ensure we have items for Biblios
        // Fetch existing biblio or create simple one if none
        $biblio = Biblio::first();
        if (!$biblio) {
             $biblio = Biblio::create([
                'title' => 'Laravel for Beginners',
                'author_id' => 1, // assumes stub
                'publisher_id' => 1,
                'input_date' => now(),
                'last_update' => now()
             ]);
        }

        // Create Items
        $itemCodes = ['B001-001', 'B001-002', 'B001-003', 'B001-004'];
        foreach ($itemCodes as $code) {
             if (!Item::where('item_code', $code)->exists()) {
                 Item::create([
                     'item_code' => $code,
                     'biblio_id' => $biblio->biblio_id,
                     'input_date' => now(),
                     'last_update' => now()
                 ]);
             }
        }

        // 4. Create Loans (History & Active & Overdue)
        
        // History (Returned)
        Loan::create([
            'item_code' => 'B001-001',
            'member_id' => 'M001',
            'loan_date' => now()->subDays(20)->toDateString(),
            'due_date' => now()->subDays(13)->toDateString(),
            'return_date' => now()->subDays(10)->toDateString(),
            'is_return' => 1,
            'input_date' => now(),
            'last_update' => now()
        ]);

        // Active (Not Overdue)
        Loan::create([
            'item_code' => 'B001-002',
            'member_id' => 'M002',
            'loan_date' => now()->subDays(2)->toDateString(),
            'due_date' => now()->addDays(5)->toDateString(),
            'is_return' => 0,
            'input_date' => now(),
            'last_update' => now()
        ]);

        // Overdue (Active but Late)
        Loan::create([
            'item_code' => 'B001-003',
            'member_id' => 'M003',
            'loan_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(3)->toDateString(),
            'is_return' => 0,
            'input_date' => now(),
            'last_update' => now()
        ]);

        // 5. Create Reservations
        // M001 reserves B001-003 (which is currently overdue with M003)
        Reservation::create([
            'member_id' => 'M001',
            'item_code' => 'B001-003',
            'reservation_date' => now()->toDateString(),
            'is_active' => true
        ]);
        
        $this->command->info('Circulation data seeded successfully!');
    }
}
