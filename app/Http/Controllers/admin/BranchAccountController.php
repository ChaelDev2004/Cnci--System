<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BranchAccountCredentials;
use App\Models\Pastor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BranchAccountController extends Controller
{
    public function index()
    {
        User::ensureColumns();

        $branches = User::query()
            ->where('role', User::ROLE_BRANCH)
            ->with('pastor')
            ->orderByDesc('id')
            ->get();

        return view('content.dashboard.admin.branches.index', compact('branches'));
    }

    public function create()
    {
        User::ensureColumns();
        $pastors = Pastor::orderBy('name')->get();

        return view('content.dashboard.admin.branches.create', compact('pastors'));
    }

    public function store(Request $request)
    {
        User::ensureColumns();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'pastor_id' => 'required|exists:pastors,id',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8',
            'send_email' => 'nullable|boolean',
        ]);

        $plainPassword = $validated['password'] ?? Str::password(12);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $plainPassword,
            'role' => User::ROLE_BRANCH,
            'pastor_id' => $validated['pastor_id'],
        ]);

        $user->load('pastor');
        $mailSent = false;
        $mailError = null;

        if ($request->boolean('send_email')) {
            try {
                Mail::to($user->email)->send(new BranchAccountCredentials(
                    $user,
                    $plainPassword,
                    route('login')
                ));
                $mailSent = true;
            } catch (\Throwable $e) {
                $mailError = $e->getMessage();
            }
        }

        $message = 'Branch account created for ' . $user->email . '.';
        if ($mailSent) {
            $message .= ' Login credentials were emailed.';
        } elseif ($request->boolean('send_email')) {
            $message .= ' Email could not be sent — share this temporary password manually: ' . $plainPassword;
            if ($mailError) {
                $message .= ' (' . Str::limit($mailError, 120) . ')';
            }
        } else {
            $message .= ' Temporary password: ' . $plainPassword;
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', $message);
    }

    public function edit(User $branch)
    {
        $this->ensureBranch($branch);
        $pastors = Pastor::orderBy('name')->get();

        return view('content.dashboard.admin.branches.edit', [
            'branch' => $branch,
            'pastors' => $pastors,
        ]);
    }

    public function update(Request $request, User $branch)
    {
        $this->ensureBranch($branch);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($branch->id)],
            'pastor_id' => 'required|exists:pastors,id',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8',
            'resend_email' => 'nullable|boolean',
        ]);

        $branch->name = $validated['name'];
        $branch->email = $validated['email'];
        $branch->phone = $validated['phone'] ?? null;
        $branch->pastor_id = $validated['pastor_id'];

        $plainPassword = null;
        if (! empty($validated['password'])) {
            $plainPassword = $validated['password'];
            $branch->password = $plainPassword;
        }

        $branch->save();
        $branch->load('pastor');

        $message = 'Branch account updated.';

        if ($request->boolean('resend_email')) {
            if (! $plainPassword) {
                $plainPassword = Str::password(12);
                $branch->password = $plainPassword;
                $branch->save();
            }

            try {
                Mail::to($branch->email)->send(new BranchAccountCredentials(
                    $branch,
                    $plainPassword,
                    route('login')
                ));
                $message .= ' Credentials emailed to ' . $branch->email . '.';
            } catch (\Throwable $e) {
                $message .= ' Email failed — temporary password: ' . $plainPassword;
            }
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', $message);
    }

    public function destroy(User $branch)
    {
        $this->ensureBranch($branch);
        $branch->delete();

        return back()->with('success', 'Branch account removed.');
    }

    private function ensureBranch(User $branch): void
    {
        if (! $branch->isBranch()) {
            abort(404);
        }
    }
}
