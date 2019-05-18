<?php

namespace FRohlfing\Auth\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class AddUserCommand extends Command
{
    /**
     * Exit Codes.
     */
    const EXIT_SUCCESS = 0;
    const EXIT_FAILURE = 1;

    /**
     * Configuration
     *
     * @var array
     */
    protected $config;

    /**
     * The name and signature of the console command.
     *
     * Inherited options:
     *   -h, --help            Display this help message
     *   -q, --quiet           Do not output any message
     *   -V, --version         Display this application version
     *       --ansi            Force ANSI output
     *       --no-ansi         Disable ANSI output
     *   -n, --no-interaction  Do not ask any interactive question
     *       --env[=ENV]       The environment the command should run under
     *   -v|vv|vvv, --verbose  Increase the verbosity of messages
     *
     * @var string
     */
    protected $signature = 'user:add
            { username : Username }
            { password : Password }
            { --d|name= : Display Name <comment>[default: <username>]</comment> }
            { --m|email= : E-Mail Address <comment>[default: <username>@local.site]</comment> }
            { --r|role=%1 : User role <comment>[%2]</comment> }
            { --t|api_token= : API token <comment>[default: a randomly generated unique string]</comment>) }
            { --l|rate_limit=%3 : Rate Limit }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user account.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->signature = str_replace('%1', config('auth.roles.0') , $this->signature);
        $this->signature = str_replace('%2', implode(', ', config('auth.roles')) , $this->signature);
        $this->signature = str_replace('%3', config('auth.rate_limit') , $this->signature);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = array_only(array_merge($this->arguments(), $this->options()), [
            'username', 'password', 'name', 'email', 'role', 'api_token', 'rate_limit'
        ]);

        // Validate

        if (!in_array($input['role'], config('auth.roles'))) {
            $this->error('Role not defined');
            return static::EXIT_FAILURE;
        }

        if (empty($input['name'])) {
            $input['name'] = $input['username'];
        }

        if (empty($input['email'])) {
            $input['email'] = str_slug(strtolower($input['username']), '_') . '@local.site';
        }

        if (empty($input['api_token'])) {
            $input['api_token'] = str_unique_random(60);
        }

        $input['password_confirmation'] = $input['password'];

        app()->setLocale('en');
        $validator = Validator::make($input, User::rules(), [], __('auth::model'));
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return static::EXIT_FAILURE;
        }

        // Save

        try {
            $user = new User;
            $user->name       = $input['name'];
            $user->username   = $input['username'];
            $user->email      = $input['email'];
            $user->email_verified_at = $user->freshTimestamp();
            $user->password   = bcrypt($input['password']);
            $user->role       = $input['role'];
            $user->api_token  = $input['api_token'];
            $user->rate_limit = $input['rate_limit'];
            $user->save();
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return static::EXIT_FAILURE;
        }

        return static::EXIT_SUCCESS;
    }
}
