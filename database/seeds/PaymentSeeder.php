<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'payment_plan'=>'Cash',
            ),
            array(
                'payment_plan'=>'Cheque',
            ),
        );
        DB::table('payment_methods')->insert($data);
    }
}
