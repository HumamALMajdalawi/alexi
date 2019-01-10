    <?php

use Illuminate\Database\Seeder;
use App\Models\Lookup;

class LookupSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

       $lookups = array(
            array('id' => '1', 'name' => 'Active', 'category' => 'General Status', 'status' => 'A', 'value' => null),
            array('id' => '2', 'name' => 'Disable', 'category' => 'General Status', 'status' => 'A', 'value' => null),
            array('id' => '3', 'name' => 'Active', 'category' => 'Register Status', 'status' => 'A', 'value' => null),
            array('id' => '4', 'name' => 'Disable', 'category' => 'Register Status', 'status' => 'A', 'value' => null),
            array('id' => '5', 'name' => 'Pending', 'category' => 'Register Status', 'status' => 'A', 'value' => null),
            array('id' => '6', 'name' => 'Complete', 'category' => 'Register Status', 'status' => 'A', 'value' => null),
            array('id' => '7', 'name' => 'Reject', 'category' => 'Register Status', 'status' => 'A', 'value' => null),
            array('id' => '8', 'name' => 'Male','category' => 'Gender', 'status' => 'A', 'value' => null),
            array('id' => '9', 'name' => 'Female','category' => 'Gender', 'status' => 'A', 'value' => null),
            array('id' => '10','name' => 'Both','category' => 'Gender', 'status' => 'D', 'value' => null),
            array('id' => '11','name' => 'smtp','category' => 'Mail Driver', 'status' => 'A', 'value' => null),
            array('id' => '12','name' => 'mailgun','category' => 'Mail Driver', 'status' => 'A', 'value' => null),
            array('id' => '13','name' => 'SSL','category' => 'Mail Encryption', 'status' => 'A', 'value' => null),
            array('id' => '14','name' => 'TLS','category' => 'Mail Encryption', 'status' => 'A', 'value' => null),
            array('id' => '15', 'name' => 'Activation', 'category' => 'Email Notification', 'status' => 'A', 'value' => null),
            array('id' => '16', 'name' => 'English', 'category' => 'Language', 'status' => 'A', 'value' => null),
            array('id' => '17', 'name' => 'Arabic', 'category' => 'Language', 'status' => 'A', 'value' => null),
            
            array('id' => '18', 'name' => 'Mr.', 'category' => 'Salutation', 'status' => 'A', 'value' => 'mr'),
            array('id' => '19', 'name' => 'Mrs.', 'category' => 'Salutation', 'status' => 'A', 'value' => 'ms'),
            array('id' => '20', 'name' => 'Mdm.', 'category' => 'Salutation', 'status' => 'A', 'value' => 'mdm'),

            array('id' => '21', 'name' => 'Public', 'category' => 'authorization', 'status' => 'A', 'value' => 'PR'),
            array('id' => '22', 'name' => 'Private', 'category' => 'authorization', 'status' => 'A', 'value' => 'PB'),

            array('id' => '23', 'name' => 'Online', 'category' => 'Payment Through', 'status' => 'A', 'value' => 'PB'),
            array('id' => '24', 'name' => 'Offline', 'category' => 'Payment Through', 'status' => 'A', 'value' => 'PB'),

            array('id' => '25', 'name' => 'Pending', 'category' => 'Payment Status', 'status' => 'A', 'value' => null),
            array('id' => '26', 'name' => 'Approved', 'category' => 'Payment Status', 'status' => 'A', 'value' => null),
            array('id' => '27', 'name' => 'Rejected', 'category' => 'Payment Status', 'status' => 'A', 'value' => null),

            array('id' => '28', 'name' => 'PDF', 'category' => 'Download Type', 'status' => 'A', 'value' => null),
            array('id' => '29', 'name' => 'Excel', 'category' => 'Download Type', 'status' => 'A', 'value' => null),

            array('id' => '30', 'name' => 'Married', 'category' => 'Marital Status', 'status' => 'A', 'value' => null),
            array('id' => '31', 'name' => 'Single', 'category' => 'Marital Status', 'status' => 'A', 'value' => null),
            array('id' => '32', 'name' => 'Separated', 'category' => 'Marital Status', 'status' => 'A', 'value' => null),
            array('id' => '33', 'name' => 'Widowed', 'category' => 'Marital Status', 'status' => 'A', 'value' => null),
            array('id' => '34', 'name' => 'Divorced', 'category' => 'Marital Status', 'status' => 'A', 'value' => null),
        );

       
        foreach ($lookups as $lookup) {
            $data = array(
                'id'                => $lookup['id'],
                'name'              => $lookup['name'],
                'category'        => $lookup['category'],
                'status'            => $lookup['status'],
                'value'            => $lookup['value']
            );

            $data_exists = Lookup::find($lookup['id']);
            if (!is_null($data_exists)) {
                Lookup::where('id', $lookup['id'])
                        ->update($data); //UPDATE
            } else {
                Lookup::create($data); //CREATE
            }
        }

        $this->command->info('Lookups table seeded');
    }

}
