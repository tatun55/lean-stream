<?php


namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionRecord;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TransactionRecordSeeder extends Seeder
{
    public function run()
    {
        $userId = User::where('name', 'テスト＿管理組合')->first()->id;
        $oranisationId = Organisation::where('name', 'Aマンション管理組合')->first()->id;
        $bankAccounts = [];
        $bankAccounts[] = BankAccount::create([
            'organisation_id' => $oranisationId,
            'transaction_type' => 'general',
            'management_name' => 'テスト＿管理組合用普通口座',
            'note' => 'テスト用の普通銀行口座です',
            'bank_name' => '三菱東京UFJ銀行',
            'branch_name' => '新宿支店',
            'account_type' => 'savings',
            'account_number' => '1234567',
            'account_holder' => 'テスト＿管理組合',
        ]);
        $bankAccounts[] = BankAccount::create([
            'organisation_id' => $oranisationId,
            'transaction_type' => 'special',
            'management_name' => 'テスト＿管理組合用特別口座',
            'note' => 'テスト用の特別銀行口座です',
            'bank_name' => '三菱東京UFJ銀行',
            'branch_name' => '新宿支店',
            'account_type' => 'savings',
            'account_number' => '7654321',
            'account_holder' => 'テスト＿管理組合',
        ]);
        for ($i = 0; $i < 200; $i++) {
            $type = ['deposit', 'withdrawal', 'other'][rand(0, 2)];
            $purpose = ['管理費', '修繕積立金', 'その他'][rand(0, 2)];
            $bankAccount = $bankAccounts[rand(0, 1)];
            TransactionRecord::create([
                'id' => Str::uuid(),
                'transaction_date' => now()->subDays(rand(1, 500)),
                'type' => $type,
                'amount' => rand(100, 10000) * 100,
                'purpose' => $purpose,
                'paid' => 1,
                'user_id' => $userId,
                'organisation_id' => $oranisationId,
                'bank_account_id' => $bankAccount->id,
            ]);
        }
    }
}
