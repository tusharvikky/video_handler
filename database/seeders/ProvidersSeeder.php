<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $g_provider = Provider::create(['name' => 'Google']);
        $s_provider = Provider::create(['name' => 'Snapchat']);

        DB::table('providers_meta')->insert([[
        	'provider_id' => $g_provider->id,
        	'type' => 'image/jpeg',
        	'description' => 'Must be in aspect ratio 4:3 & < 2 mb size',
        	'rule' => 'mimes:jpeg|max:2048|dimensions:ratio=4/3',
        	'rule_length' => NULL
        ],[
        	'provider_id' => $g_provider->id,
        	'type' => 'video/mp4',
        	'description' => 'Must be < 1 minute long',
        	'rule' => 'mimes:mp4',
        	'rule_length' => 60
        ],[
        	'provider_id' => $g_provider->id,
        	'type' => 'audio/mpeg',
        	'description' => 'Must be < 30 seconds long & < 5mb size',
        	'rule' => 'mimes:mp3|max:5120',
        	'rule_length' => 30
        ],[
        	'provider_id' => $s_provider->id,
        	'type' => 'image/jpeg',
        	'description' => 'Must be in aspect ratio 16:9 & < 5 mb size',
        	'rule' => 'mimes:jpeg|max:5120|dimensions:ratio=16/9',
        	'rule_length' => NULL
        ],[
        	'provider_id' => $s_provider->id,
        	'type' => 'image/gif',
        	'description' => 'Must be in aspect ratio 16:9 & < 5 mb size',
        	'rule' => 'mimes:gif|max:5120|dimensions:ratio=16/9',
        	'rule_length' => NULL
        ],[
        	'provider_id' => $s_provider->id,
        	'type' => 'video/mp4',
        	'description' => 'Must be < 5 minutes long & < 50mb in size',
        	'rule' => 'mimes:mp4|max:51200',
        	'rule_length' => 300
        ],[
        	'provider_id' => $s_provider->id,
        	'type' => 'video/quicktime',
        	'description' => 'Must be < 5 minutes long & < 50mb in size',
        	'rule' => 'mimes:mov|max:51200',
        	'rule_length' => 300
        ]]);
    }
}
