<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AvtosInterface
{

    public function getAll();
    public function getWithRecordsByUser(int $userId);
    public function searchAutos(string $search);
    public function serchAvtosJoinRecordsUsers($s,$id_user);
    public function getByBorder(int $id);

}
