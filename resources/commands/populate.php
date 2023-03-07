<?php

/**
 * Populate the database with data.
 */

declare(strict_types = 1);

use App\Interface\LocalAccountProviderInterface;
use App\Service\CustomerService;
use App\Service\DeviceService;
use App\Service\TicketService;

$c = require __DIR__ . '/../../bootstrap.php';

$accountProvider = $c->get(LocalAccountProviderInterface::class);
$customerService = $c->get(CustomerService::class);
$deviceService = $c->get(DeviceService::class);
$ticketService = $c->get(TicketService::class);

if($accountProvider->getGroupByName('admins') == null)
{
    $accountProvider->createGroup([
        'name' => 'admins',
        'priv_level' => 0
    ]);
}

if($accountProvider->getGroupByName('technicians') == null)
{
    $accountProvider->createGroup([
        'name' => 'technicians',
        'priv_level' => 1
    ]);
}

if($accountProvider->getGroupByName('guests') == null)
{
    $accountProvider->createGroup([
        'name' => 'guests',
        'priv_level' => 2
    ]);
}

if($accountProvider->getAccountByEmail('admin@email.com') == null)
{
    $accountProvider->createAccount([
        'email' => 'admin@email.com',
        'password' => 'hello',
        'first_name' => 'Benjamin',
        'last_name' => 'Moss',
        'group' => 'admins'
    ]);
}

if($accountProvider->getAccountByEmail('technician@email.com') == null)
{
    $accountProvider->createAccount([
        'email' => 'technician@email.com',
        'password' => 'hello',
        'first_name' => 'Jaques',
        'last_name' => 'Shrimp',
        'group' => 'technicians'
    ]);
}

if($customerService->getByEmail('harry@cat.com') == null)
{
    $customerService->create([
        'email' => 'harry@cat.com',
        'password' => 'hello',
        'first_name' => 'Harry',
        'last_name' => 'Cat',
        'mobile' => '07123456789'
    ]);
}

if($customerService->getByEmail('joy@cat.com') == null)
{
    $customerService->create([
        'email' => 'joy@cat.com',
        'password' => 'hello',
        'first_name' => 'Joy',
        'last_name' => 'Cat',
        'mobile' => '07123987654'
    ]);
}

if($deviceService->getBySerial('2ZQLNN8TJ4PNL8PV') == null)
{
    $owner = $customerService->getByEmail('harry@cat.com');

    $deviceService->create([
        'manufacturer' => 'Banana',
        'model' => 'bPhone 6',
        'serial' => '2ZQLNN8TJ4PNL8PV',
        'imei' => '7547789465785',
        'locator' => 'AA1',
        'owner' => $owner
    ]);
}

if($deviceService->getBySerial('SMLKXGPEKKH6NWT3') == null)
{
    $owner = $customerService->getByEmail('joy@cat.com');

    $deviceService->create([
        'manufacturer' => 'Banana',
        'model' => 'bPhone 7',
        'serial' => 'SMLKXGPEKKH6NWT3',
        'imei' => '4767447892856',
        'locator' => 'AA2',
        'owner' => $owner
    ]);
}

if($deviceService->getBySerial('4EV9G9EHEQTWEH6L') == null)
{
    $owner = $customerService->getByEmail('joy@cat.com');

    $deviceService->create([
        'manufacturer' => 'Pear',
        'model' => 'Mixx Pro 10',
        'serial' => '4EV9G9EHEQTWEH6L',
        'imei' => '5325936452477',
        'locator' => 'AA3',
        'owner' => $owner
    ]);
}

if($ticketService->getById(1) == null)
{
    $t = $accountProvider->getAccountByEmail('admin@email.com');
    $cst = $customerService->getByEmail('harry@cat.com');
    $d = $deviceService->getBySerial('2ZQLNN8TJ4PNL8PV');

    $ticketService->create([
        'subject' => 'Battery Replacement',
        'issue_type' => 'Hardware',
        'status' => 0,
        'technician' => $t,
        'customer' => $cst,
        'device' => $d
    ]);
}