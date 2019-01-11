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
    protected $signature = 'user:add';

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
        $key = config('auth.key');
        $keyLabel = $key !== 'email' ? __("users.model.{$key}", [], 'en') : 'E-Mail Address';

        $this->signature .= '
            { ' . $key . ' : ' . $keyLabel . ' } 
            { password : Password }
            { --d|name= : Display Name (default: <' . $key . '>) }
            ' . ($key !== 'email' ? '{ --m|email= : E-Mail Address (default: <' . $key . '>@local) }' : '') . '
            { --r|role= : User role (default: ' . config('auth.roles.0') . ') }
            { --t|api_token= : API token (default: generated string) }
            { --l|rate_limit= : Rate Limit (default: ' . config('auth.rate_limit') . ') }';

        //$this->signature = str_replace(' name : Display Name', ' email2 : E-Mail', $this->signature);

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
        $key = config('auth.key');

        try {
            $user = new User;
            $user->setAttribute($key, $data[$key]);
            $user->password = bcrypt($data['password']);
            $user->name     = !empty($data['name']) ? $data['name'] : $data[$key];
            if ($key !== 'email') {
                $user->email = !empty($data['email']) ? $data['email'] : str_slug(strtolower($data[$key]), '_') . '@local';
            }
            $user->role       = !empty($data['role']) ? $data['role'] : config('auth.roles.0');
            $user->api_token  = !empty($data['api_token']) ? $data['api_token'] : str_unique_random(60);
            $user->rate_limit = !empty($data['rate_limit']) ? $data['rate_limit'] : config('auth.rate_limit');
            $user->save();
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return static::EXIT_FAILURE;
        }

        return static::EXIT_SUCCESS;
    }
}
