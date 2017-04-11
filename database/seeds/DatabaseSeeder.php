<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $tables = [
            'bill_commodity',
            'bill_import_returns',
            'bill_returns',
            'bill_sales',
            'bill_sale_commodities',
            'bill_shippings',
            'branches',
            'branch_commodities',
            'commodities',
            'commodity_groups',
            'commodity_images',
            'companies',
            'customers',
            'histories',
            'password_resets',
            'purchase_orders',
            'purchase_order_commodities',
            'purchase_returns',
            'purchase_return_commodities',
            'stock_takes',
            'stock_take_commodities',
            'suppliers',
            'users'          
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        $this->users();
        // $this->call(UsersTableSeeder::class);
    }

    public function users() {
        DB::table('companies')->insert([
            'name' => 'Company 1',
            'email' => 'company1@gmail.com',
            'address' => 'Cam lo - Quang Tri',            
            'mobile'=> '0906521623',
            'phone'=> '0906521623',
            'status'=> 1
        ]);
        DB::table('branches')->insert([
            'name' => 'Chi nhanh company 1',
            'address' => 'Cam Hieu - Cam Lo - Quang Tri',            
            'company_id'=> 1,
            'mobile'=> '0906521623',
            'phone'=> '0906521623',
            'status'=> 1
        ]);
        DB::table('branches')->insert([
            'name' => 'Chi nhanh company 2',
            'address' => 'Cam Hieu - Cam Lo - Quang Tri',            
            'company_id'=> 1,
            'mobile'=> '0906521623',
            'phone'=> '0906521623',
            'status'=> 1
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'nickname' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role_id' => 1,            
            'gender'=> 1,
            'status'=> 1
        ]);
        DB::table('users')->insert([
            'name' => 'Manager',
            'nickname' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('manager'),
            'gender'=> 1,
            'company_id' => 1,
            'role_id' => 2,            
            'status'=> 1
        ]);
        DB::table('users')->insert([
            'name' => 'Staff',
            'nickname' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('staff'),
            'gender'=> 1,
            'company_id' => 1,
            'role_id' => 3,            
            'status'=> 1
        ]);

        DB::table('commodity_groups')->insert([
            'name' => 'Commodity group 1',
            'description' => 'Commodity group 1',
            'parent_id' => 0,
            'status'=> 1,
            'company_id' => 1
        ]);
        DB::table('commodity_groups')->insert([
            'name' => 'Commodity group 2',
            'description' => 'Commodity group 2',
            'parent_id' => 0,
            'status'=> 1,
            'company_id' => 1
        ]);
        DB::table('commodity_groups')->insert([
            'name' => 'Commodity group 1-1',
            'description' => 'Commodity group 1',
            'parent_id' => 1,
            'status'=> 1,
            'company_id' => 1
        ]);
        DB::table('commodity_groups')->insert([
            'name' => 'Commodity group 2-1',
            'description' => 'Commodity group 1',
            'parent_id' => 2,
            'status'=> 1,
            'company_id' => 1
        ]);
    }
}
