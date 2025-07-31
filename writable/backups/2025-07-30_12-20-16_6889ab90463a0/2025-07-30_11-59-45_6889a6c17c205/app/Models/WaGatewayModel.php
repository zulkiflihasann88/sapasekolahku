<?php

namespace App\Models;

use CodeIgniter\Model;

class WaGatewayModel extends Model
{
    protected $table = 'wa_gateway_config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['domain', 'apikey', 'api_url', 'api_key', 'device_id', 'status'];
    public $timestamps = false;
}
