<?php

namespace App\Console\Commands;

use App\Notifications\UserHasUnreadConversations;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class SendEmailUserHasUnreadConversations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-unread';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails to all users who have unread messages in the last four hours.';

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

        // This checks whether a user got a new message in the last four hours.

        $fourHoursAgo = Carbon::now()->subHours(4)->toDateTimeString();

        $usersIds = DB::table('conversation_user')
            ->where('is_unread', '=', 1)
            ->where('last_active', '>', $fourHoursAgo)
            ->pluck('user_id');

        $users = User::find($usersIds);

        $users->each(function ($user) {
            $user->notify(new UserHasUnreadConversations());
        });

        $this->info('Successfully send ' . $usersIds->count() .' emails.');

    }
}
