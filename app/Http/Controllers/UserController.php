<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Get site users.
     *
     * Currently getting all.
     */
    public function index(Request $request) {
        if ($request->user()->id == 1) {
            $orderBy = 'created_at';
            if ($request->order) {
                $orderBy = $request->order;
            }

            $users = User::whereNull('moved_out')->orderByDesc($orderBy)->get();

            return view('user.index', [
                'users' => $users,
            ]);
        } else {
            return redirect('home');
        }
    }


    /**
     * Return a single user.
     */
    public function get(Request $request) {
        // Assume currently authenticated user unless another ID is passed.
        $user = $request->user()->with(['location', 'connections']);

        // TODO - ensure we have security around people requesting other users.
        // $id = $request->input('id', $authUser->id);
        // if ($id !== $authUser->id) {
        //     // This isn't for the currently authenticated user.
        //     $user = User::find($id);
        // }

        return response()->json($user);
    }

    public function edit(Request $request) {
        $user = $request->user();
        $location = $user->location;
        $template = $request->route()->getName() == 'user.show'
            ? 'user.profile.me'
            : 'user.profile.me-edit';

        return view('user.profile.full', [
            'user' => $user,
            'location' => $location,
            'template' => $template
        ]);
    }

    public function update(Request $request) {

        // Limit photo upload to 5MB then resize it.
        $validator = Validator::make(
            $request->all(),
            [
                'photo' => 'max:5120|mimes:jpg,jpeg,png,gif',
                'birthdate' => 'nullable|date',
                'first' => 'required',
                'last' => 'required',
                'email' => 'required|email',
                'password' => 'nullable|min:6|max:50|confirmed',
                'password_confirmation' => 'nullable|min:6|max:50',
                'moved_in' => 'nullable|date',
                'moved_out' => 'nullable|date',
                'visibility' => 'required'
            ],
            [
                'photo.max' => 'Sorry Charlie, you\'re photo is waaaaaay too big.',
                'photo.mimes' => 'You tried to tricks is with a weird file you sneaky hobbit! Only images please.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('user.edit')
                ->withErrors($validator)
                ->withInput();
        }

        // Update non-file fields.
        $input = collect($request->all())->only([
            'first', 'middle', 'last', 'email', 'password', 'phone',
            'moved_in', 'moved_out', 'intro', 'birth_date', 'visibility'
        ]);

        // Only save password if it has a valid value that matches the confirmed.
        if (!$input->get('password')) {
            $input->forget('password');
        } else {
            $input['password'] = Hash::make($input->get('password'));
        }

        // Grab the current user and fill with all non-file values.
        $user = $request->user;
        $user->fill($input->toArray());

        // Resize image and save full and thumb.
        if ($request->file('photo')) {
            $photo_hash = 'avatars/' . md5(env('APP_KEY') . $user->id . 'avatar');
            $photo_hash_thumb = 'avatars/' . md5(env('APP_KEY') . $user->id . 'avatar_thumb');

            // Avatar - HD - 1366 (x 768) max
            $photo = Image::make($request->file('photo'))->resize(1366, 1366,
                function($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })->orientate()
                ->encode('webp', 60)
                ->stream();

            Storage::put($photo_hash, $photo, 'public');

            // Avatar - thumbnail - 200
            $photo_thumb = Image::make($request->file('photo'))->resize(200, 200,
                function($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })->orientate()
                ->encode('webp', 60)
                ->stream();

            Storage::put($photo_hash_thumb, $photo_thumb, 'public');

            $user->photo = $photo_hash;
            $user->photo_thumb = $photo_hash_thumb;
        }

        $user->save();

        // Flash success message.
        $request->session()->flash('success',
            'You successfully updated your profile!'
        );

        return redirect()->route('user.show');
    }

    public function destroyPhoto(Request $request) {
        $user = $request->user();
        $user->photo = null;
        $user->photo_thumb = null;
        $user->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Get members of this neighborhood.
     *
     * TODO - filter by parent group that represents a neighborhood.
     */
    public function getMembers() {
        $all = User::whereNull('moved_out')->get();
        $users = $all->map(function($item) {
            return [$item->location_id, ['last' => 'N/A']];
        });
        return response()->json($users);
    }

    /**
     * Get list of this user's friends/connections.
     */
    public function getUserConnections(Request $request)
    {
        $connections= $request->user()->connections()
            ->select('users.id', 'users.first', 'users.middle', 'users.last')
            ->get();
        return response()->json($connections);
    }

}
