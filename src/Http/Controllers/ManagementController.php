<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $input = $request->input();

        /** @var User|Builder $builder */
        $builder = User::query();

        if (isset($input['search'])) {
            $builder = $builder->search($input['search']);
        }

        if (isset($input['sort_by'])) {
            $builder = $builder->orderBy($input['sort_by'], isset($input['sort_order']) ? $input['sort_order'] : 'asc');
        }

        $perPage = config('auth.per_page', 100);
        if (isset($input['per_page']) && $input['per_page'] * 1 < $perPage) {
            $perPage = $input['per_page'];
        }

        $users = $builder->paginate($perPage)->appends($input);

        return view('auth::management.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user)
    {
        return view('auth::management.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $user = new User;
        if (config('auth.manage_api')) {
            $user->rate_limit = config('auth.rate_limit');
        }

        return view('auth::management.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        if (is_superior($request->input('role'))) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $keys = [];
        if (config('auth.hide_username')) {
            $keys[] = 'username';
        }
        $input = $request->except($keys);
        $rules = array_except($user->getRules(), $keys);
        $validator = Validator::make($input, $rules, [], __('auth::model'));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = new User;
        $user->name       = $input['name'];
        $user->username   = !config('auth.hide_username') ? $input['username'] : uniqid('u');
        $user->email      = $input['email'];
        $user->email_verified_at = $user->freshTimestamp();
        $user->password   = bcrypt($input['password']);
        $user->role       = $input['role'];
        $user->api_token  = str_unique_random(60);
        $user->rate_limit = $input['rate_limit'];

        $user->save();

        return redirect('admin/users')->with('message', __('auth::management.form.successful_created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user)
    {
        if (is_superior($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return view('auth::management.form', compact('user'));
    }

    /**
     * Clone the given model and shows the edit view.
     *
     * @param \App\User $user
     * @return View
     */
    public function replicate(User $user)
    {
        if (is_superior($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = $user->replicate();

        return view('auth::management.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (is_superior($request->input('role')) || is_superior($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $keys = [];
        if (config('auth.hide_username')) {
            $keys[] = 'username';
        }
        if (empty($request->input('password'))) {
            $keys[] = 'password';
            $keys[] = 'password_confirmation';
        }
        $input = $request->except($keys);
        $rules = array_except($user->getRules(), $keys);
        $validator = Validator::make($input, $rules, [], __('auth::model'));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (!empty($request->input('password'))) {
            $input['password'] = bcrypt($input['password']);
        }

        $user->update($input);

        return redirect('admin/users')->with('message', __('auth::management.form.successful_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if (is_superior($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user->delete();

        return redirect('admin/users')->with('message', __('auth::management.form.successful_deleted'));
    }

    /**
     * Verify the email address.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function verify(User $user)
    {
        $user->markEmailAsVerified();

        return redirect()->back()->with('message', __('auth::management.form.email_verified'));
    }
}