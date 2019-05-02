<?php

namespace FRohlfing\Auth\Console\Commands;

use App\User;
use Illuminate\Console\Command;

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
            { --m|email= : E-Mail Address <comment>[default: <username>@local]</comment> }
            { --r|role=%1 : User role }
            { --t|api_token= : API token <comment>[default: a randomly generated unique string]</comment>) }
            { --l|rate_limit=%2 : Rate Limit }';

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
        $this->signature = str_replace('%2', config('auth.rate_limit') , $this->signature);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = array_merge($this->arguments(), $this->options());

        try {
            $user = new User;
            $user->name       = !empty($data['name']) ? $data['name'] : $data['username'];
            $user->username   = $data['username'];
            $user->email      = !empty($data['email']) ? $data['email'] : str_slug(strtolower($data['username']), '_') . '@local';
            $user->password   = bcrypt($data['password']);
            $user->role       = $data['role'];
            $user->api_token  = !empty($data['api_token']) ? $data['api_token'] : str_unique_random(60);
            $user->rate_limit = $data['rate_limit'];
            $user->save();
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return static::EXIT_FAILURE;
        }

        return static::EXIT_SUCCESS;
    }
}
