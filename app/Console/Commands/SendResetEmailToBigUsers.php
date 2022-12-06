<?php

namespace App\Console\Commands;

use App\Email;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;

class SendResetEmailToBigUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send reset emails to bigcommerce users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::where('is_guest', 0)
            ->whereNotNull('big_id')
            ->whereNull('is_reset_email_sent')
            ->orderBy('id', 'asc')
            ->first();
        if (!empty($user)) {
            $broker = Password::broker();

            $reset_token = $broker->createToken($user);

            $placeHolders = [
                '[Customer Name]'       => $user->name ?? '',
                '[Reset Password Link]' => url("/password/reset/" . $reset_token . '/' . $user->email),
            ];
            Email::sendEmail('customer.reset_link_big_users', $placeHolders, $user->email ?? '');
            $user->is_reset_email_sent = 1;
            $user->save();
        }
    }
}
