<?php

namespace App\Models;
use Edmarr2\D4sign\Services\D4sign;
use Edmarr2\D4sign\Services\Account;
use Edmarr2\D4sign\Services\Batches;
use Edmarr2\D4sign\Services\Certificate;
use Edmarr2\D4sign\Services\Documents;
use Edmarr2\D4sign\Services\Folders;
use Edmarr2\D4sign\Services\Groups;
use Edmarr2\D4sign\Services\Safes;
use Edmarr2\D4sign\Services\Tags;
use Edmarr2\D4sign\Services\Templates;
use Edmarr2\D4sign\Services\Users;
use Edmarr2\D4sign\Services\Watcher;

class D4signLocal extends D4sign
{
    public $account = new Account();
    public $batches = new Batches();
    public $certificate = new Certificate();
    public $documents = new Documents();
    public $folders = new Folders();
    public $groups = new Groups();
    public $safes = new Safes();
    public $tags = new Tags();
    public $templates = new Templates();
    public $users = new Users();
    public $watcher = new Watcher();
    public function __construct($account, $batches, $certificate, $documents, $folders, $groups, $safes, $tags, $templates, $users, $watcher){

        parent::__construct($account, $batches, $certificate, $documents, $folders, $groups, $safes, $tags, $templates, $users, $watcher);
    }
}
