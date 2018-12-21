<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $builder
     * @return \Illuminate\View\View
     */
    public function index(Request $request, User $builder)
    {
        $input = request()->input();

        if (isset($input['search'])) {
            $builder = $builder->search($input['search']);
        }

        if (isset($input['sort_by'])) {
            $builder = $builder->orderBy($input['sort_by'], isset($input['sort_order']) ? $input['sort_order'] : 'asc');
        }

        // todo sortby und order ersetzen mit sort_by und sort_order
        if (isset($input['sortby'])) {
            $builder = $builder->orderBy($input['sortby'], isset($input['order']) ? $input['order'] : 'asc');
        }

        $users = $builder->paginate(config('auth::per_page'))->appends($input);

        return view('auth::management.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('auth::management.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth::management.form', ['user' => new User]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        if (is_superior($request->input('role'))) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $input = $request->input();
        $validator = Validator::make($input, $user->getRules(), [], __('auth::model'));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input['password'] = bcrypt($input['password']);

        /** @var User $user */
        /** @noinspection PhpUndefinedMethodInspection */
        $user = $user->create($input);

        // api_token must be explicitly assigned because it does not belong to the fillable fields
        $user->api_token = str_unique_random(60);
        $user->save();

        return redirect('admin/users')->with('message', __('auth::management.form.successful_created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\View\View
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
     * @return \Illuminate\View\View
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
     * @param \Illuminate\Http\Request  $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (is_superior($request->input('role')) || is_superior($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (empty($request->input('password'))) {
            $input = $request->except(['password', 'password_confirmation']);
            $validator = Validator::make($input, array_except($user->getRules(), 'password'), [], __('auth::model'));
        }
        else {
            $input = $request->input();
            $validator = Validator::make($input, $user->getRules(), [], __('auth::model'));
        }

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
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
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
     * Confirm the email address.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(User $user)
    {
        $user->confirmation_token = null;
        $user->save();

        return redirect()->back()->with('message', __('auth::management.form.email_confirmed'));
    }
}