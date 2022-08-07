<?php

namespace App\Contracts;

interface SendSubscriberNotificationContract
{

    public function setSubscribers();

    public function getSubscribers();

    public function sendNotification();
}
